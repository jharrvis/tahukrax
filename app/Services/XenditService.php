<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class XenditService
{
    protected string $secretKey;
    protected string $baseUrl = 'https://api.xendit.co';

    public function __construct()
    {
        $this->secretKey = config('services.xendit.secret_key') ?? '';

        if (empty($this->secretKey)) {
            Log::warning('Xendit Secret Key is missing in configuration.');
        }
    }

    public function createInvoice(array $data)
    {
        try {
            $response = Http::withBasicAuth($this->secretKey, '')
                ->post("{$this->baseUrl}/v2/invoices", [
                    'external_id' => $data['external_id'],
                    'amount' => $data['amount'],
                    'payer_email' => $data['payer_email'],
                    'description' => $data['description'],
                    'invoice_duration' => 86400, // 24 hours
                    'should_send_email' => true,
                    'success_redirect_url' => route('order.success', $data['order_id']),
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Xendit Invoice Creation Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Xendit Service Exception', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
