<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;
    protected $guarded = [];

    function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    function orders()
    {
        return $this->hasMany(Order::class);
    }

    function usage()
    {
        return $this->hasMany(Order::class)->where('status', '4');
    }

    function showStatus(){
        return match($this->is_active){
            '1' => 'Aktif',
            '0' => 'Tidak Aktif',
            default => 'Tidak Diketahui'
        };
    }
}
