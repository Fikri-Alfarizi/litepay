<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $connection = 'gateway';

    protected $fillable = ['user_id', 'name', 'api_key', 'api_secret', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function apiKeys()
    {
        return $this->hasMany(ApiKey::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
