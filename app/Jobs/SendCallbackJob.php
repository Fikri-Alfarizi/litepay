<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\CallbackLog;
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

        $payload = [
            'invoice_id' => $this->transaction->invoice_id,
            'status' => $this->transaction->status,
            'amount' => $this->transaction->amount,
            'payment_channel' => $this->transaction->payment_channel,
            'paid_at' => $this->transaction->paid_at ? $this->transaction->paid_at->toIso8601String() : null,
            'timestamp' => now()->timestamp,
        ];

        // Sign the payload
        $signature = $signatureService->generate($payload, $merchant->api_secret);

        $log = CallbackLog::create([
            'transaction_id' => $this->transaction->id,
            'payload' => json_encode($payload),
            'attempts' => 1,
        ]);

        try {
            $response = Http::withHeaders([
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])->post($merchant->callback_url, $payload);

            $log->update([
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

        } catch (\Exception $e) {
            $log->update([
                'response_status' => 500,
                'response_body' => $e->getMessage(),
            ]);
            
            // Re-queue if needed, logic for retry can be here
        }
    }
}
