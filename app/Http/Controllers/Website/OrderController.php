<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $merchants = Merchant::all();
        return view('order.index', compact('merchants'));
    }

    public function data(Request $request){
        $query = Order::query();
        $query->with('services','payment','user','merchant','vehicle','voucher');

        $query->when($request->status, function($q) use ($request){
            $q->where('status', $request->status);
        });

        $query->when($request->search, function($q) use ($request){
            $q->where('invoice', 'like', '%'.$request->search.'%');
        });

        $query->when($request->merchant_id, function($q) use ($request){
            $q->where('merchant_id', $request->merchant_id);
        });

        $query->latest();

        $list = $query->paginate($request->limit ?? 10);

        return view('order.list', compact('list'));
    }

    public function view(Order $order){
        $order->load('services','payment','user','merchant','vehicle','voucher');
        return view('order.view', compact('order'));
    }
}
