<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentCallback extends Model
{
    protected $connection = 'merchant';

    public $timestamps = false;

    protected $fillable = ['invoice_id', 'status', 'payload', 'received_at'];
}
