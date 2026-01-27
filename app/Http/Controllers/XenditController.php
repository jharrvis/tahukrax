<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $callbackToken = config('services.xendit.webhook_token');
        $xenditCallbackToken = $request->header('x-callback-token');

        if ($callbackToken && $xenditCallbackToken !== $callbackToken) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid callback token'
            ], 403);
        }

        $payload = $request->all();
        Log::info('Xendit Webhook Received', $payload);

        $externalId = $payload['external_id'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$externalId) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        // Extract Order ID from external_id (e.g., ORDER-123-167890)
        $parts = explode('-', $externalId);
        $orderId = $parts[1] ?? null;

        if (!$orderId) {
            return response()->json(['message' => 'Invalid external ID format'], 400);
        }

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($status === 'PAID' || $status === 'SETTLED') {
            $order->update([
                'status' => 'paid',
            ]);

            foreach ($order->orderItems as $item) {
                if ($item->addon) {
                    $item->addon->decrement('stock', $item->quantity);
                }
            }

            Log::info("Order #{$orderId} has been PAID and stock decremented.");
        } elseif ($status === 'EXPIRED') {
            $order->update([
                'status' => 'cancelled',
            ]);
            Log::info("Order #{$orderId} has EXPIRED.");
        }

        return response()->json(['status' => 'success']);
    }
}
