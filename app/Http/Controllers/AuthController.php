<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Administrateur;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('AccessToken')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user->Administrateur->user_id], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
}
