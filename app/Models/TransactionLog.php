<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $connection = 'gateway';

    public $timestamps = false;

    protected $fillable = ['transaction_id', 'action', 'payload'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
