<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Play;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;

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
        if ($user->hasRole('player')) {
            $diceOne = rand(1, 7);
            $diceTwo = rand(1, 7);
            $sum = ($diceOne + $diceTwo);
            $requestData = [
                'diceOne' => $diceOne,
                'diceTwo' => $diceTwo,
                'sum' => $sum,
                'user_id' => $user->id,
            ];
            $this->store($requestData);
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
            'sum' => 'required|integer',
            'user_id' => 'required',
        ]);
        $play = Play::create([
            'diceOne' => $validate['diceOne'],
            'diceTwo' => $validate['diceTwo'],
            'sum' => $validate['sum'],
            'user_id' => $validate['user_id'],

        ]);
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
            return response()->json(['error' => 'no autorizado'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
