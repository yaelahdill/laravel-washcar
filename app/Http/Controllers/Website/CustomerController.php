<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        $total = User::count();
        return view('customer.index',[
            'total' => $total,
        ]);
    }

    public function data(Request $request){
        $query = User::query();

        $query->when($request->search, function($q) use($request){
            $q->where('name', 'like', '%' . $request->search . '%');
            $q->orWhere('email', 'like', '%' . $request->search . '%');
            $q->orWhere('phone', 'like', '%' . $request->search . '%');
        });

        $list = $query->paginate(10);

        return view('customer.list', compact('list'));
    }

    public function view(User $customer){
        $count_order = Order::where('user_id', $customer->id)->count();
        $total_order = Order::where('user_id', $customer->id)->sum('total');

        return view('customer.view', [
            'customer' => $customer,
            'count_order' => $count_order,
            'total_order' => $total_order,
        ]);
    }

    public function data_order(Request $request){
        $query = Order::query();
        $query->with('merchant', 'services', 'payment');

        $query->where('user_id', $request->user_id);

        $query->when($request->search, function($q) use($request){
            $q->where('id', 'like', '%' . $request->search . '%');
            $q->orWhere('total', 'like', '%' . $request->search . '%');
            $q->orWhere('status', 'like', '%' . $request->search . '%');
        });

        $query->when($request->date, function($q) use($request){
            $explode = explode(' - ', $request->date);
            $q->whereBetween('created_at', [$explode[0] . ' 00:00:00', $explode[1] . ' 23:59:59']);
        });

        $query->latest();
        $list = $query->paginate(10);

        return view('customer.order', compact('list'));
    }

}
