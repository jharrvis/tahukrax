<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CekatWebhookController extends Controller
{
    /**
     * Handle incoming webhook from Cekat.biz.id
     */
    public function handle(Request $request)
    {
        // 1. Ambil Signature & Header
        $signature = $request->header('X-Cekat-Signature');
        $timestamp = $request->header('X-Cekat-Timestamp');
        $secret = config('services.cekat.secret');

        // Jika secret belum diset di .env, log error tapi mungkin jangan abort jika testing tanpa signature (opsional, tapi best practice harus verify)
        if (empty($secret)) {
            Log::error('Cekat Webhook Error: CEKAT_WEBHOOK_SECRET not configured.');
            return response()->json(['message' => 'Server configuration error'], 500);
        }

        // 2. Verifikasi HMAC SHA256
        $payload = $request->getContent();
        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);

        if (!hash_equals($expected, (string) $signature)) {
            Log::warning('Cekat Webhook Invalid Signature', [
                'expected' => $expected,
                'received' => $signature,
                'payload' => $payload
            ]);
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        // 3. Proses Action
        $action = $request->input('action');

        Log::info("Cekat Webhook Action: {$action}", $request->all());

        try {
            switch ($action) {
                case 'save_lead':
                    return $this->handleSaveLead($request);

                case 'check_status':
                    return $this->handleCheckStatus($request);

                default:
                    return response()->json(['status' => 'ignored', 'message' => "Action '$action' not handled"]);
            }
        } catch (\Exception $e) {
            Log::error('Cekat Webhook Exception: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error'], 500);
        }
    }

    private function handleSaveLead(Request $request)
    {
        // Validasi minimal
        if (!$request->input('name') && !$request->input('phone')) {
            return response()->json(['status' => 'error', 'message' => 'Name or Phone required'], 400);
        }

        DB::table('leads')->insert([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'interest' => $request->input('interest'),
            'source' => 'chatbot',
            'status' => 'new',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'success']);
    }

    private function handleCheckStatus(Request $request)
    {
        $search = $request->input('query'); // Bisa Order ID atau Resi

        if (empty($search)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mohon sertakan ID Pesanan atau Nomor Resi.'
            ]);
        }

        // Cari berdasarkan ID atau tracking_number
        $order = Order::where('id', $search)
            ->orWhere('tracking_number', $search)
            ->first();

        if ($order) {
            $statusText = ucfirst($order->status);
            $resiText = $order->tracking_number ? "Resi: {$order->tracking_number}" : "Resi belum tersedia";

            return response()->json([
                'status' => 'success',
                'message' => "Halo! Pesanan #{$order->id} Anda saat ini berstatus: *{$statusText}*. {$resiText}.",
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'tracking_number' => $order->tracking_number,
                    'total_amount' => $order->total_amount
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'not_found',
                'message' => "Maaf, pesanan dengan ID atau Resi '$search' tidak ditemukan. Mohon cek kembali."
            ]);
        }
    }
}
