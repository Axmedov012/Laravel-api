<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($validate)){
            return response()->json([
                'message' => 'Login Failed'
            ],401);
        }
        $user = User::where('email', $validate['email'])->first();
        return response()->json([
            'access_token'=>$user->createToken('api_token')->plainTextToken, // Token olish
            'token_type'=>'Bearer', // token turi
        ],201);
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user=User::create($validate); // user yaratadi
        return response()->json([ // json formatda javob qaytarish
            'data'=>$user,
            'access_token'=>$user->createToken('api_token')->plainTextToken, // yangi user ga token yaratadi
            'token_type'=>'Bearer', // token turi
        ]);
    }
}
