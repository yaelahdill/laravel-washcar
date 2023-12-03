<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function index()
    {
        $total = Banner::count();
        return view('banner.index', [
            'total' => $total
        ]);
    }

    public function data(Request $request){
        $banners = Banner::query();

        $banners->latest();

        $list = $banners->paginate(10);

        return view('banner.list', compact('list'));
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'image' => 'required|image'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $image = $request->file('image');
        $ext = $image->getClientOriginalExtension();
        $name = rand(100000,999999) . time() . ".{$ext}";
        $image->save(public_path('images'), $name);

        $banner = Banner::create([
            'title' => 'required|string',
            'image' => $name
        ]);

        return response()->json([
            'result' => true,
            'message' => "Berhasil menambahkan banner"
        ]);

    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:banners'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $banner = Banner::find($request->id);
        $banner->delete();

        return response()->json([
            'result' => true,
            'message' => "Berhasil menghapus banner"
        ]);
    }
}
