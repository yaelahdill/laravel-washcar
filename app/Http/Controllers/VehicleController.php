<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function index(Request $request){
        $query = Vehicle::query();
        $query->where('user_id', $request->user()->id);
        $query->latest();

        $vehicles = $query->get();
        $array = [];

        foreach ($vehicles as $vehicle) {
            $array[] = [
                'id' => $vehicle->id,
                'plate_number' => $vehicle->plate_number,
                'category' => $vehicle->category,
                'size' => $vehicle->size,
                'brand' => $vehicle->brand,
                'created_at' => $vehicle->created_at->diffForHumans(),
            ];
        }

        return response()->json([
            'result' => true,
            'data' => $array,
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'plate_number' => 'required|string',
            'category' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $vehicle = Vehicle::create([
            'user_id' => $request->user()->id,
            'plate_number' => $request->plate_number,
            'category' => $request->category,
            'size' => $request->size,
            'brand' => $request->brand,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Kendaraan berhasil di tambahkan',
            'data' => [
                'id' => $vehicle->id,
                'plate_number' => $vehicle->plate_number,
                'category' => $vehicle->category,
                'size' => $vehicle->size,
                'brand' => $vehicle->brand,
                'created_at' => $vehicle->created_at->diffForHumans(),
            ],
        ]);
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'plate_number' => 'required|string',
            'category' => 'required|string',
            'size' => 'required|string',
            'brand' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $vehicle = Vehicle::where([
            'user_id' => $request->user()->id,
            'id' => $request->id,
        ])->first();
        if(!$vehicle){
            return response()->json([
                'result' => false,
                'message' => 'Kendaraan tidak ditemukan',
            ]);
        }

        $vehicle->update([
            'plate_number' => $request->plate_number,
            'category' => $request->category,
            'size' => $request->size,
            'brand' => $request->brand,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Kendaraan berhasil di update',
            'data' => [
                'id' => $vehicle->id,
                'plate_number' => $vehicle->plate_number,
                'category' => $vehicle->category,
                'size' => $vehicle->size,
                'brand' => $vehicle->brand,
                'created_at' => $vehicle->created_at->diffForHumans(),
            ],
        ]);
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(),[
            'id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $vehicle = Vehicle::where([
            'id' => $request->id,
            'user_id' => $request->user()->id,
        ])->first();
        if(!$vehicle){
            return response()->json([
                'result' => false,
                'message' => 'Kendaraan tidak ditemukan',
            ]);
        }

        $vehicle->delete();

        return response()->json([
            'result' => true,
            'message' => 'Kendaraan berhasil di hapus',
        ]);
    }
}
