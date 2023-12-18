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
        return $this->belongsTo(User::class);
    }

    function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    function vehicle()
    {
        return $this->hasOne(OrderVehicle::class);
    }

    function voucher(){
        return $this->belongsTo(Voucher::class);
    }

    function showStatus(){
        return match($this->status){
            '1' => 'Menunggu Pembayaran',
            '2' => 'Sudah Dibayar',
            '3' => 'Sedang Diproses',
            '4' => 'Selesai',
            '5' => 'Dibatalkan',
            default => 'Tidak Diketahui'
        };
    }
}
