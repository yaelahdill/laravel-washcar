<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function get_services(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|exists:merchants,id', 
            'vehicle_id' => 'required|exists:vehicles,id',
        ],[
            'merchant_id.required' => 'ID merchant tidak boleh kosong',
            'merchant_id.exists' => 'Merchant tidak ditemukan',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $vehicle = Vehicle::where([
            'user_id' => $request->user()->id,
            'id' => $request->vehicle_id
        ])->first();
        if(!$vehicle){
            return response()->json([
                'result' => false,
                'message' => "Kendaraan tidak ditemukan"
            ]);
        }

        $services = Service::where([
            'merchant_id' => $request->merchant_id,
            'category' => $vehicle->category,
            'type' => $vehicle->size
        ])->get();
        $array = [];

        foreach($services as $service){
            $array[] = [
                'id' => $service->id,
                'name' => $service->name,
                'description' => $service->description,
                'estimated_time' => $service->estimated_time,
                'price' => $service->price,
            ];
        }

        return response()->json([
            'result' => true,
            'message' => 'ok',
            'data' => $array
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|integer|exists:merchants,id',
            'vehicle_id' => 'required|integer|exists:vehicles,id',
            'service_ids' => 'required|array',
            'payment_method' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }
    }
}
