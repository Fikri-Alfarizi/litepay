<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CallbackLog extends Model
{
    protected $fillable = ['transaction_id', 'payload', 'response_status', 'response_body', 'attempts'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
