<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public function index(Request $request){
        $query = Merchant::query();

        if($request->has('name')){
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if($request->has('phone')){
            $query->where('phone', 'like', '%'.$request->phone.'%');
        }

        if($request->has('email')){
            $query->where('email', 'like', '%'.$request->email.'%');
        }

        $query->orderBy('name', 'asc');

        $array = [];
        foreach($query->get() as $item){
            $array[] = [
                'id' => $item->id,
                'name' => $item->name,
                'phone' => $item->phone,
                'email' => $item->email,
                'address' => $item->address,
                'city' => $item->city,
                'opening_hours' => $item->opening_hours,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at
            ];
        }

        return response()->json([
            'result' => true,
            'message' => 'List merchant berhasil diambil',
            'data' => $array
        ]);
    }
}
