<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiceMatch;
use App\Models\diceMatch;
use Illuminate\Http\Request;


class ApiDiceMatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diceMatches = DiceMatch::all();
        return response()->json([
            'status' => true,
            'diceMatches' => $diceMatches,
        ]);
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
    public function store(StoreDiceMatch $request)
    {
        //dd($request->all());
        $diceMatch = DiceMatch::create($request->all());

        return response()->json([
            'status' => true,
            'message' => "Product Created successfully!",
            'product' => $diceMatch
        ], 200);
    }
   /* public function store(Request $request)
    {
        
    }*/

    /**
     * Display the specified resource.
     */
    public function show(diceMatch $diceMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(diceMatch $diceMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, diceMatch $diceMatch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(diceMatch $diceMatch)
    {
        //
    }
}
