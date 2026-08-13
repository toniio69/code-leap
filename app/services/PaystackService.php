<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected ?string $secretKey = null;

    protected ?string $publicKey = null;

    protected string $baseUrl;

    public function __construct()
    {
        $this->publicKey = config('services.paystack.public_key') ?? config('paystack.publicKey');
        $this->secretKey = config('services.paystack.secret_key') ?? config('paystack.secretKey');
        $this->baseUrl = rtrim(config('services.paystack.payment_url') ?? config('paystack.paymentUrl', 'https://api.paystack.co'), '/');
    }

    public function getPublicKey(): ?string
    {
        return $this->publicKey;
    }

    /**
     * Initialize a Paystack transaction.
     * Amount must be passed in Kobo (e.g. 1000 NGN = 100000 Kobo).
     */
    public function initializeTransaction(array $payload): array
    {
        if (!$this->secretKey) {
            return [
                'status' => false,
                'message' => 'Paystack secret key is not configured.',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->secretKey,
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
            ])->post($this->baseUrl.'/transaction/initialize', $payload);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Paystack initialization failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Paystack API request failed',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack initialization exception', ['error' => $e->getMessage()]);

            return [
                'status' => false,
                'message' => 'Unable to connect to Paystack payment gateway: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify a Paystack transaction by reference.
     */
    public function verifyTransaction(string $reference): array
    {
        if (!$this->secretKey) {
            return [
                'status' => false,
                'message' => 'Paystack secret key is not configured.',
            ];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->secretKey,
                'Cache-Control' => 'no-cache',
            ])->get($this->baseUrl.'/transaction/verify/'.urlencode($reference));

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'body' => $response->body(),
            ]);

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Paystack verification failed',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification exception', ['error' => $e->getMessage()]);

            return [
                'status' => false,
                'message' => 'Error verifying transaction: '.$e->getMessage(),
            ];
        }
    }
}
