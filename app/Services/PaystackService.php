<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaystackService
{
    protected string $secretKey;

    protected string $publicKey;

    protected string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
    }

    /**
     * Initialize a payment transaction
     *
     * @param  array{email: string, amount: int, reference: string, callback_url: string, metadata?: array}  $data
     * @return array{status: bool, message: string, data?: array}
     */
    public function initializeTransaction(array $data): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->post("{$this->baseUrl}/transaction/initialize", [
                    'email' => $data['email'],
                    'amount' => $data['amount'] * 100, // Paystack expects amount in kobo/cents
                    'reference' => $data['reference'],
                    'callback_url' => $data['callback_url'],
                    'metadata' => $data['metadata'] ?? [],
                    'currency' => 'KES',
                ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'message' => 'Transaction initialized',
                    'data' => $response->json('data'),
                ];
            }

            Log::error('Paystack initialization failed', [
                'response' => $response->json(),
                'status' => $response->status(),
            ]);

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Failed to initialize transaction',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack initialization error', [
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => 'An error occurred while initializing payment',
            ];
        }
    }

    /**
     * Verify a transaction
     *
     * @return array{status: bool, message: string, data?: array}
     */
    public function verifyTransaction(string $reference): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get("{$this->baseUrl}/transaction/verify/{$reference}");

            if ($response->successful()) {
                $data = $response->json('data');

                return [
                    'status' => $data['status'] === 'success',
                    'message' => $data['gateway_response'] ?? 'Transaction verified',
                    'data' => $data,
                ];
            }

            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'response' => $response->json(),
            ]);

            return [
                'status' => false,
                'message' => $response->json('message') ?? 'Failed to verify transaction',
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification error', [
                'reference' => $reference,
                'error' => $e->getMessage(),
            ]);

            return [
                'status' => false,
                'message' => 'An error occurred while verifying payment',
            ];
        }
    }

    /**
     * Get list of banks
     *
     * @return array{status: bool, data?: array}
     */
    public function getBanks(string $country = 'kenya'): array
    {
        try {
            $response = Http::withToken($this->secretKey)
                ->get("{$this->baseUrl}/bank", [
                    'country' => $country,
                ]);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json('data'),
                ];
            }

            return [
                'status' => false,
                'data' => [],
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'data' => [],
            ];
        }
    }

    /**
     * Validate webhook signature
     */
    public function validateWebhookSignature(string $payload, string $signature): bool
    {
        $computedSignature = hash_hmac('sha512', $payload, $this->secretKey);

        return hash_equals($computedSignature, $signature);
    }

    /**
     * Generate a unique transaction reference
     */
    public function generateReference(): string
    {
        return 'IMOLE_'.time().'_'.strtoupper(bin2hex(random_bytes(8)));
    }

    /**
     * Get the public key for frontend use
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
