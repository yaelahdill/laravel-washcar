<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderService extends Model
{
    use HasFactory;
    protected $guarded = [];

    function order()
    {
        return $this->belongsTo(Order::class);
    }

    function service()
    {
        return $this->belongsTo(Service::class);
    }
}
