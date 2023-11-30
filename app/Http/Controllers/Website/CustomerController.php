<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function data(Request $request){
        $query = User::query();

        $query->when($request->search, function($q) use($request){
            $q->where('name', 'like', '%' . $request->search . '%');
        });

        return $query->paginate(10);
    }

}
