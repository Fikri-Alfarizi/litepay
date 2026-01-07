<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'merchant';

    protected $fillable = [
        'user_id',
        'product_id',
        'product_name',
        'total_amount',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }
}
