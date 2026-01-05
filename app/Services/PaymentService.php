<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Support\Str;

class PaymentService
{
    public function createTransaction(Merchant $merchant, array $data): Transaction
    {
        return Transaction::create([
            'merchant_id' => $merchant->id,
            'invoice_id' => $data['invoice_id'],
            'amount' => $data['amount'],
            'payment_channel' => $data['payment_channel'] ?? 'virtual_account',
            'status' => 'PENDING',
            'reference_id' => Str::upper(Str::random(12)), // Simulation reference
        ]);
    }
}
