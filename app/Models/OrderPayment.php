<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $connection = 'merchant';

    protected $fillable = [
        'order_id',
        'invoice_id',
        'gateway_transaction_id',
        'payment_status',
        'paid_at',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'gateway_transaction_id');
    }
}
