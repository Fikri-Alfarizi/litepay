<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallbackAttempt extends Model
{
    protected $connection = 'gateway';

    protected $fillable = ['transaction_id', 'callback_url', 'response_code', 'status'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
