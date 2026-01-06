<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Support\Str;

class PaymentService
{
    public function createTransaction(Merchant $merchant, array $data): Transaction
    {
        // Calculate Fees
        $amount = $data['amount'];
        $fee = 2500; // Flat admin fee
        $tax = $amount * 0.11; // 11% PPN
        $totalAmount = $amount + $fee + $tax;

        return Transaction::create([
            'merchant_id' => $merchant->id,
            'invoice_id' => $data['invoice_id'],
            'amount' => $amount,
            'fee' => $fee,
            'tax' => $tax,
            'total_amount' => $totalAmount,
            'product_name' => $data['product_name'] ?? 'Unknown Product',
            'payment_channel' => $data['payment_channel'] ?? 'virtual_account',
            'user_id' => $data['user_id'] ?? null,
            'destination_number' => $data['destination_number'] ?? null,
            'status' => 'PENDING',
            'reference_id' => Str::upper(Str::random(12)), // Simulation reference
        ]);
    }
    public function updateStatus(Transaction $transaction, string $status)
    {
        if ($transaction->status === 'SUCCESS' || $transaction->status === 'FAILED') {
            return; // Immutable terminal states
        }

        $transaction->update([
            'status' => $status,
            'paid_at' => $status === 'SUCCESS' ? now() : null,
        ]);

        if ($status === 'SUCCESS') {
            // Inbox Notification (Local Feature)
            \App\Models\Inbox::create([
                'user_id' => $transaction->user_id,
                'title' => 'Pembayaran Berhasil!',
                'message' => "Pembayaran untuk {$transaction->product_name} senilai Rp " . number_format($transaction->total_amount, 0, ',', '.') . " telah berhasil.",
                'type' => 'success'
            ]);

            // Balance Increment (Upstream Feature)
            if ($transaction->user_id && Str::contains($transaction->product_name, 'Top Up')) {
                $user = \App\Models\User::find($transaction->user_id);
                if ($user) {
                    $user->increment('balance', $transaction->amount);
                }
            }
        }

        // Dispatch Callback
        \App\Jobs\SendCallbackJob::dispatch($transaction);
    }
}
