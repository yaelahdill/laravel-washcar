<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Service;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request){
        $total_customer = User::where('role', 'customer')->count();
        $total_merchant = Merchant::count();
        $total_service = Service::count();
        $total_voucher = Voucher::where('is_active', 1)->count();
        $last_orders = Order::with('merchant','user','services')->limit(5)->orderBy('created_at', 'desc')->get();
        $orders = Order::get();
        return view('dashboard', [
            'total_customer' => $total_customer,
            'total_merchant' => $total_merchant,
            'total_service' => $total_service,
            'total_voucher' => $total_voucher,
            'last_orders' => $last_orders,
            'jumlah_pesanan' => $orders->count(),
            'pesanan_success' => $orders->where('status', '4')->count(),
            'pesanan_proccess' => $orders->whereIn('status', [2,3])->count(),
            'total_pesanan' => "Rp".number_format($orders->sum('total'), 0, '.', '.'),
        ]);
    }
}
