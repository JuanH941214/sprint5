<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiceMatch;
use App\Models\MatchResults;
use Illuminate\Http\Request;


class matchResultsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $diceMatches = MatchResults::all();
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
    public function store(request $request)
    {
        //dd($request->all());
        $diceMatch = MatchResults::create($request->all());

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
    public function show(request $diceMatch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(request $diceMatch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(request $diceMatch)
    {
        //
    }
}
