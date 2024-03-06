<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Play;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($user) {
            $players = User::role('player')->get();
            return response()->json([
                'status' => true,
                'users' => $players,
                'message' => 'players retrieved succesfully!',

            ], 200);
        } else {
            return response()->json(['error' => 'no autorizado'], 401);
        }
    
  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(request $request)
    {
        $validated = $request->validate([
            'nick_name' => 'nullable|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:8'
        ]);
        if(!$request->filled('nick_name')){
            $validated['nick_name']='Anonymous';
        }
        $user = User::create([
            'nick_name' => $validated['nick_name'],//request->name otra opcion 
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        if ($user) {
            Auth::login($user);
            $user->assignRole('player'); 
            return response()->json([
                'status' => true,
                'message' => 'user created succesfully!',
                //'user' => $user,
            ], 201);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create user.',
            ], 500);
        }
       
    }

   

    /**
     * Display the specified resource.//ranking 
     */
    public function showRanking(request $request)
    {
        $user = auth()->user();
        if ($user) {
            $ranking=$this->ranking();
            return response()->json([
                'status' => true,
                'message' => 'ranking retrieved succesfully!',
                'ranking' => $ranking, 
             ],200);    

        } else {
            return response()->json(['error' => 'no autorizado'], 401);
        }
    }

    public function calculateWinRate($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
        $totalPlays=$this->totalGamesPerPlayer($id);
        $gamesWon=$this->gamesWonPerPLayer($id);
        $newWinRate=($totalPlays > 0) ? ($gamesWon * 100) / $totalPlays : 0;//? como condicion // : como resultado si es falso
        $user->update(['win_rate' =>$newWinRate]);
        return response()->json(['message' => 'Win rate actualizado con éxito'], 200);

    }

    public function totalGamesPerPlayer($id)
    {
        $user= User::find($id);
        $totalPlays= Play::where('user_id',$user->id)->count();
        if($totalPlays){
            return $totalPlays;
        }
        else {
            return 0;
        }   
    }

    public function gamesWonPerPLayer($id)
    {
        $user= User::find($id);
        $totalPlays= Play::where('user_id',$user->id)->where('result',7)->count();
        if($totalPlays){
            return $totalPlays;
        }
        else {
            return 0;
        }   
    }

    public function update(Request $request,string $id)
    {
        $user = auth()->user();
        if(!$user){
            return response()->json(['error' => 'no autorizado'], 401);
        }

        elseif($user->hasRole('player')){
            $request->validate([
                'nick_name' => 'required|string',
            ]);
              $userToUpdate = User::find($id);
              $userToUpdate->update([
                'nick_name'=> $request->input('name'),
            ]);
              return response()->json(['message' => 'user updated'],200);
        }    
    }



    /**
     * Show the form for editing the specified resource.
     */
    //**************************SOLO ADMIN*************************************
    public function ranking()
    {
        $ranking = DB::table('users')
        ->select('users.id', 'users.win_rate','users.nick_name')
        ->join('model_has_roles','users.id','=','model_has_roles.model_id')
        ->join('roles','model_has_roles.role_id','=', 'roles.id')
        ->where('roles.name','=','player')
        ->orderByDesc('users.win_rate')
        ->get();
        return $ranking;
        
    }

    public function lowestWinRate()
    {
        $user = auth()->user();
        if ($user) {
            $ranking = DB::table('users')
            ->select('users.id', 'users.win_rate', 'users.nick_name')
            ->join('model_has_roles', 'users.id' , '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', '=', 'player')
            ->orderBy('users.win_rate')
            ->first();
            return $ranking;
        }
    }

    public function highestWinRate()
    {
        $user = auth()->user();
        if ($user) {
            $ranking = DB::table('users')
            ->select('users.id', 'users.win_rate', 'users.nick_name')
            ->join('model_has_roles', 'users.id' , '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', '=', 'player')
            ->orderByDesc('users.win_rate')
            ->first();
            return $ranking;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
