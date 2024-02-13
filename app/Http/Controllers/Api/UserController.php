<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
  
    }

    /**;
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string|min:8'
        ]);
        $user = User::create([
            'name' => $validated['name'],//request->name otra opcion 
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        Auth::login($user);
        
        return response()->json([
           'status' => true,
           'message' => 'user created succesfully!',
           'user' => $user, 
        ],201); 
       
    }
   /* public function store(Request $request)
    {
        
    }*/

    /**
     * Display the specified resource.
     */
    public function show(request $request)
    {
        $user=auth()->user();
        if($user){
            $users= User::all();
        return response()->json([
            'status' => true,
            'users' => $users,
        ],200);

        }
        else{
            return response()->json(['error'=>'no autorizado'],401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
