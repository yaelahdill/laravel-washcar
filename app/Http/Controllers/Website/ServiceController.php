<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index()
    {
        $total = Service::count();
        $merchants = Merchant::get();
        return view('service.index', [
            'total' => $total,
            'merchants' => $merchants
        ]);
    }

    public function data(Request $request){
        $services = Service::query();
        $services->with('merchant');

        $services->when($request->merchant_id, function($q) use($request){
            $q->where('merchant_id', $request->merchant_id);
        });

        $services->latest();

        $list = $services->paginate(10);

        return view('service.list', compact('list'));
    }

    public function add()
    {
        $total = Service::count();
        $merchants = Merchant::get();
        return view('service.add', [
            'merchants' => $merchants,
            'total' => $total
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|exists:merchants,id',
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'estimation' => 'required|string',
            'price' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $service = Service::create([
            'merchant_id' => $request->merchant_id,
            'name' => $request->name,
            'category' => $request->category,
            'type' => $request->type,
            'description' => $request->description,
            'estimated_time' => $request->estimation,
            'price' => str_replace(['Rp', '.', ',', ' '], '', $request->price),
        ]);

        if($service){
            return response()->json([
                'result' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }else{
            return response()->json([
                'result' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }
    }
}
