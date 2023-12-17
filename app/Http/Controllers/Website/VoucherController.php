<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VoucherController extends Controller
{
    public function index(Request $request){
        return view('voucher.index');
    }

    public function data(Request $request){
        $query = Voucher::query();

        $query->when($request->search, function($q) use($request){
            $q->where('name', 'like', '%' . $request->search . '%');
            $q->orWhere('code', 'like', '%' . $request->search . '%');
        });

        $query->when($request->status, function($q) use($request){
            $q->where('is_active', $request->status);
        });

        $query->latest();
        $list = $query->paginate(10);

        return view('voucher.list', compact('list'));
    }

    public function add(Request $request){
        $merchants = Merchant::get();
        return view('voucher.add', [
            'merchants' => $merchants
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'merchant_id' => 'required|exists:merchants,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:vouchers,code',
            'description' => 'required|string|max:255',
            'amount' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'quantity' => 'required|numeric',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $voucher = Voucher::create([
            'merchant_id' => $request->merchant_id,
            'name' => $request->name,
            'code' => str_replace(' ', '', $request->code),
            'description' => $request->description,
            'discount' => str_replace(['Rp', '.'], '', $request->amount),
            'start_date' => $request->start_date,
            'expired_at' => $request->end_date,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Voucher berhasil ditambahkan',
            'redirect' => route('voucher')
        ]);
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:vouchers,id'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        Voucher::find($request->id)->delete();

        return response()->json([
            'result' => true,
            'message' => 'Voucher berhasil dihapus',
            'redirect' => route('voucher')
        ]);
    }
}
