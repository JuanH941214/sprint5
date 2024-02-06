<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{
    public function login(request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($login)) {
            return response(['message' => 'invalid login credentials'],401);
        }
        $user=$request->user();//devolverá el modelo del usuario haciendo la solicitud al request, 
        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['token' => $token]);
    }   

     
    public function logout(request $request){
        
    }

}
