<?php

namespace App\Http\Controllers\Api;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Bridge\AccessToken;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        if (!Auth::attempt($login)) {
            return response(['message' => 'invalid login credentials'],401);
        } 
        $user = $request->user();//devolverá el modelo del usuario haciendo la solicitud al request,     
        $token = $user->createToken('authToken')->accessToken;
        return response()->json(['token' => $token]);
    }   

     
    public function logout(Request $request){
        $token = $request->user()->token();
        $token->revoke();
        return response()->json(['message' => 'Successfully logged out']);
        /*Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');*/// esta respuesta es para un logout "webased" con passpor es distinto 
    }


}
