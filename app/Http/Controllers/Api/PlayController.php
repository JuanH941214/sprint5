<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Play;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class PlayController extends Controller
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
            ], 200);
        } else {
            return response()->json(['error' => 'no autorizado'], 401);
        }
    }

    public function play(Request $request)
    {
        $user = auth()->user();
        if ($user->can('player.play')) {
            $diceOne = rand(1, 6);
            $diceTwo = rand(1, 6);
            $result = ($diceOne + $diceTwo);
            $requestData = [
                'diceOne' => $diceOne,
                'diceTwo' => $diceTwo,
                'result' => $result,
                'user_id' => $user->id,
            ];
            $this->store($requestData);
            return response(($requestData),200);
        } else {
            return response()->json(['error' => 'no tienes permiso para jugar'], 403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        $validate = Validator::make($data,[
            'diceOne' => 'required|integer',
            'diceTwo' => 'required|integer',
            'result' => 'required|integer',
            'user_id' => 'required',
        ]);
         $data=$validate->validated();
        $play = Play::create([
            'diceOne' => $data['diceOne'],
            'diceTwo' => $data['diceTwo'],
            'result' => $data['result'],
            'user_id' => $data['user_id'],

        ]);
        return response()->json([
            'status' => true,
            'message' => 'play created succesfully!',
            'play' => $play, 
         ],201);
    }

    /**
     *show all preview plays from a player
     */
    public function show(string $id)
    {
        $user = auth()->user();
        if ($user) {
            $plays = Play::where('user_id',$user->id)->get();
            return response()->json([
                'status' => true,
                'plays' => $plays,
            ], 200);
        } else {
            return response()->json(['error' => 'no autorizado'], 403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = auth()->user();
        if(!$user){
            return response()->json(['error' => 'no autorizado'], 401);
        }
        $request->validate([
            'nick_name' => 'required|string',
        ]);
        try{
        $userToUpdate = User::find($id);
        }catch (ModelNotFoundException $e){
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }         
          $userToUpdate->update($request->only('nick_name'));
          return response()->json(['message' => 'user updated'],200);
    }

    /**
     * delete all previews plays of the player
     */
    public function destroy(string $id)
    {
        $user = auth()->user();
        if ($user) {
            $play = Play::where('user_id',$user->id)->delete();
            return response()->json([
                'status' => 'all your plays have been deleted ',
            ], 200);
        } else {
            return response()->json(['error' => 'not authorized'], 401);
        }
    }
}
