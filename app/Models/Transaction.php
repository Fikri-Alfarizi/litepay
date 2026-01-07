<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'gateway';

    protected $fillable = [
        'merchant_id', 
        'invoice_id', 
        'amount', 
        'status', 
        'payment_method',
        'paid_at', 
        'reference_id'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function logs()
    {
        return $this->hasMany(TransactionLog::class);
    }

    public function callbackAttempts()
    {
        return $this->hasMany(CallbackAttempt::class);
    }
}
