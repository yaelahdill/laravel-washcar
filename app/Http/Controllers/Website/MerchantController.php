<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MerchantController extends Controller
{

    public function index(){
        $total = Merchant::count();
        return view('merchant.index',[
            'total' => $total,
        ]);
    }

    public function add(){
        $total = Merchant::count();
        return view('merchant.add', [
            'total' => $total
        ]);
    }
    
    public function data(Request $request){
        $query = Merchant::query();

        $query->when($request->search, function($q) use($request){
            $q->where('name', 'like', '%' . $request->search . '%');
            $q->orWhere('phone', 'like', '%' . $request->search . '%');
            $q->orWhere('address', 'like', '%' . $request->search . '%');
            $q->orWhere('email', 'like', '%' . $request->search . '%');
        });

        $list = $query->paginate(10);

        return view('merchant.list', compact('list'));
    }

    public function data_order(Request $request){
        $query = Order::query();
        $query->with('services','payment');

        $query->when($request->merchant_id, function($q) use($request){
            $q->where('merchant_id', $request->merchant_id);
        });

        $query->when($request->status, function($q) use($request){
            $q->where('status', $request->status);
        });

        $list = $query->paginate(10);

        return view('merchant.list_order', compact('list'));
        
    }

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

        Merchant::create($request->except('csrf_token'));

        return response()->json([
            'result' => true,
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

    public function view(Merchant $merchant){
        $count_order = Order::where('merchant_id', $merchant->id)->count();
        $total_order = Order::where('merchant_id', $merchant->id)->sum('total');

        return view('merchant.view', [
            'merchant' => $merchant,
            'count_order' => $count_order,
            'total_order' => $total_order
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
