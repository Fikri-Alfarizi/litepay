<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedAccount extends Model
{
    protected $connection = 'merchant';

    protected $fillable = ['user_id', 'provider', 'account_number', 'account_name'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
