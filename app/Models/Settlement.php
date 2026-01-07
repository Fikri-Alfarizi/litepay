<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $connection = 'gateway';

    protected $fillable = [
        'merchant_id',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'amount',
        'status',
        'processed_at',
    ];

    protected $casts = [
        'processed_at' => 'datetime',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
