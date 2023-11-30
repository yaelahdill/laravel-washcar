<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function editProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = $request->user();
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Profile berhasil diubah',
        ]);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ],[
            'old_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.confirmed' => 'Password baru tidak cocok',
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        $user = $request->user();

        if(!Hash::check($request->old_password, $user->password)){
            return response()->json([
                'result' => false,
                'message' => 'Password lama tidak cocok',
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Password berhasil diubah',
        ]);

    }
}
