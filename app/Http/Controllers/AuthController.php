<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email'=> $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Berhasil melakukan pendaftaran , silahkan login',
            'data' => $user
        ]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'=> 'required|string'
        ]);

        if($validator->fails()){
            return response()->json([
                'result' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'result' => false,
                'message' => 'Email tidak terdaftar'
            ]);
        }

        if(!Hash::check($request->password, $user->password)){
            return response()->json([
                'result' => false,
                'message' => 'Password yg di masukan salah'
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'result' => true,
            'message' => 'Login berhasil , silahkan tunggu....',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ]);
    }
}
