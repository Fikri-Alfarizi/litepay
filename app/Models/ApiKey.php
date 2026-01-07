<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $connection = 'gateway';

    protected $fillable = ['merchant_id', 'api_key', 'api_secret', 'status'];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
