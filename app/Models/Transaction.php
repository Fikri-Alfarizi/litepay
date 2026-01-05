<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['merchant_id', 'user_id', 'destination_number', 'invoice_id', 'amount', 'payment_channel', 'status', 'paid_at', 'reference_id'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function website_callback_logs() // 'callback_logs' in db
    {
        return $this->hasMany(CallbackLog::class);
    }
}
