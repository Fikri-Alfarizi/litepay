<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Support\Str;

class PaymentService
{
    public function createTransaction(Merchant $merchant, array $data): Transaction
    {
        // 1. Calculate Financials
        $amount = $data['amount'];
        $fee = 2500; 
        $tax = $amount * 0.11; 
        $totalAmount = $amount + $fee + $tax;
        $referenceId = Str::upper(Str::random(12));
        $invoiceId = $data['invoice_id'];

        // 2. Merchant DB: Create Order & OrderPayment
        $order = \App\Models\Order::create([
            'user_id' => $data['user_id'] ?? 1, // Fallback for simulation
            'product_id' => $data['product_id'] ?? null,
            'product_name' => $data['product_name'] ?? 'Digital Product',
            'total_amount' => $totalAmount,
            'status' => 'UNPAID',
        ]);

        $orderPayment = \App\Models\OrderPayment::create([
            'order_id' => $order->id,
            'invoice_id' => $invoiceId,
            'payment_status' => 'PENDING',
        ]);

        // 3. Gateway DB: Create Transaction
        $transaction = Transaction::create([
            'merchant_id' => $merchant->id,
            'user_id' => $data['user_id'] ?? null,
            'invoice_id' => $invoiceId,
            'amount' => $totalAmount, // Gateway stores total amount to be paid
            'product_name' => $data['product_name'] ?? 'Payment',
            'status' => 'PENDING',
            'payment_method' => 'QRIS',
            'reference_id' => $referenceId,
        ]);

        // 4. Gateway DB: Log Action
        $transaction->logs()->create([
            'action' => 'CREATE',
            'payload' => json_encode($data),
        ]);

        // Update OrderPayment with Gateway reference
        $orderPayment->update(['gateway_transaction_id' => $transaction->id]);

        // 5. Notify User: Pending Payment (Inbox)
        \App\Models\Inbox::create([
            'user_id' => $order->user_id,
            'title' => 'Menunggu Pembayaran',
            'message' => "Segera selesaikan pembayaran untuk invoice {$invoiceId} senilai Rp " . number_format($totalAmount, 0, ',', '.'),
            'type' => 'info' // Use 'info' for yellow/pending
        ]);

        return $transaction;
    }

    public function updateStatus(Transaction $transaction, string $status)
    {
        if ($transaction->status === 'SUCCESS' || $transaction->status === 'FAILED') {
            return; 
        }

        // 1. Gateway DB: Update Status
        $transaction->update([
            'status' => $status,
            'paid_at' => $status === 'SUCCESS' ? now() : null,
        ]);

        // 2. Gateway DB: Log Action
        $transaction->logs()->create([
            'action' => 'PAY',
            'payload' => json_encode(['method' => 'simulation', 'status' => $status]),
        ]);

        // 3. Merchant DB: Sync status back
        $orderPayment = \App\Models\OrderPayment::where('invoice_id', $transaction->invoice_id)->first();
        if ($orderPayment) {
            $orderPayment->update([
                'payment_status' => $status,
                'paid_at' => $status === 'SUCCESS' ? now() : null,
            ]);

            if ($status === 'SUCCESS') {
                $orderPayment->order->update(['status' => 'PAID']);
                
                // Inbox Notification
                \App\Models\Inbox::create([
                    'user_id' => $orderPayment->order->user_id,
                    'title' => 'Pembayaran Berhasil!',
                    'message' => "Pembayaran dengan invoice {$orderPayment->invoice_id} senilai Rp " . number_format($transaction->amount, 0, ',', '.') . " telah berhasil.",
                    'type' => 'success'
                ]);

                // Balance Increment Simulation if Top Up
                if ($orderPayment->order->product_name === 'Top Up Balance') {
                    $createLog = $transaction->logs()->where('action', 'CREATE')->first();
                    if ($createLog) {
                        $payload = json_decode($createLog->payload, true);
                        $topUpAmount = $payload['amount'] ?? 0;

                        if ($topUpAmount > 0) {
                            $user = $orderPayment->order->user;
                            if ($user) {
                                $user->increment('balance', $topUpAmount);

                                \App\Models\Inbox::create([
                                    'user_id' => $user->id,
                                    'title' => 'Top Up Berhasil!',
                                    'message' => "Saldo Anda telah bertambah sebesar Rp " . number_format($topUpAmount, 0, ',', '.'),
                                    'type' => 'success'
                                ]);
                            }
                        }
                    }
                }
            } elseif ($status === 'FAILED') {
                 // Update Pending Notification to Failed/Cancelled
                 \App\Models\Inbox::where('user_id', $orderPayment->order->user_id)
                    ->where('message', 'LIKE', "%{$transaction->invoice_id}%")
                    ->where('title', 'Menunggu Pembayaran')
                    ->update([
                        'title' => 'Pembayaran Dibatalkan',
                        'message' => "Pembayaran untuk invoice {$transaction->invoice_id} telah dibatalkan.",
                        'type' => 'error'
                    ]);
            }
        }

        // 4. Dispatch Callback (Gateway -> Merchant notification)
        \App\Jobs\SendCallbackJob::dispatch($transaction);
    }
}
