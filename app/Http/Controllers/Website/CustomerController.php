<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
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
        return view('customer.view', compact('customer'));
    }

}
