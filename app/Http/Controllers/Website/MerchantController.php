<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:merchants',
            'phone' => 'required|string',
            'address' => 'required|string',
            'email' => 'required|email',
            'city' => 'required|string',
            'opening_hours' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        Merchant::create($request->all());

        return response()->json([
            'result' => false,
            'message' => "Berhasil menambahkan merchant"
        ]);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:merchants',
            'name' => 'required|string|unique:merchants,name,except,name',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'opening_hours' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $merchant = Merchant::find($request->id);
        $merchant->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'opening_hours' => $request->opening_hours
        ]);

        return response()->json([
            'result' => true,
            'message' => "Berhasil memperbarui merchant"
        ]);
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:merchants'
        ],[
            'id.required' => 'Pilih merchant terlebih dahulu',
            'id.exists' => 'Merchant tidak terdaftar'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $merchant = Merchant::find($request->id);
        $merchant->delete();

        return response()->json([
            'result' => true,
            'message' => 'Berhasil menghapus merchant'
        ]);
    }
}
