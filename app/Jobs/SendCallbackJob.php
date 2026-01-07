<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use App\Services\SignatureService;

class SendCallbackJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     */
    public function handle(SignatureService $signatureService): void
    {
        $merchant = $this->transaction->merchant;
        if (!$merchant || !$merchant->callback_url) {
            return;
        }

        // Resolve API Secret for the merchant
        $apiKeyRecord = \App\Models\ApiKey::where('merchant_id', $merchant->id)->first();
        if (!$apiKeyRecord) {
            return;
        }

        $payload = [
            'invoice_id' => $this->transaction->invoice_id,
            'status' => $this->transaction->status === 'SUCCESS' ? 'paid' : strtolower($this->transaction->status),
            'amount' => $this->transaction->amount,
            'timestamp' => now()->timestamp,
        ];

        // Sign the payload
        $signature = $signatureService->generate($payload, $apiKeyRecord->api_secret);

        try {
            $response = Http::withHeaders([
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->timeout(5)->post($merchant->callback_url, $payload);

            // Log attempt
            $this->transaction->callbackAttempts()->create([
                'callback_url' => $merchant->callback_url,
                'response_code' => $response->status(),
                'status' => $response->successful() ? 'SUCCESS' : 'FAILED',
            ]);

            // If success, log total action
            if ($response->successful()) {
                $this->transaction->logs()->create([
                    'action' => 'CALLBACK_SENT',
                    'payload' => json_encode($payload),
                ]);
            }

        } catch (\Exception $e) {
            $this->transaction->callbackAttempts()->create([
                'callback_url' => $merchant->callback_url,
                'response_code' => 500,
                'status' => 'FAILED',
            ]);
        }
    }
}
