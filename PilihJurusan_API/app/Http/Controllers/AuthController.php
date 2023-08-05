<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request) //functio untuk login di aplikasi mobile
    {
        $formField = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (auth()->attempt($formField)) {
            $user = User::where('email', $formField['email'])->first();
            $token = $user->createToken('pilihjurusan')->plainTextToken;

            $user = Auth::user();
            $accessToken = $user->token();
        
        if (!$accessToken || $accessToken->revoked) {
            // Token tidak valid atau sudah dinonaktifkan
            return response()->json(['message' => 'Token tidak valid. Harap login ulang.'], 401);
        }

            return response([
                'user' => $user,
                'token' => $token,
            ], 200);
        } else {
            return response([
                'message' => 'Invalid Credentials',
            ], 401);
        }
    }
    public function checkToken()//function untuk cek token bearer 
    {
        return response()->json('Valid');
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
    }
}
