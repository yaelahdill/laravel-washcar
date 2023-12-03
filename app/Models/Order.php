<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    function services()
    {
        return $this->hasMany(OrderService::class);
    }

    function payment()
    {
        return $this->hasOne(OrderPayment::class);
    }

    function user()
    {
        return $this->hasOne(User::class);
    }

    function merchant()
    {
        return $this->hasOne(Merchant::class);
    }
}
