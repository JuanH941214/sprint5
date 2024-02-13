<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\matchResultsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
 //   return $request->user();
    
//});
Route::apiResource('diceMatch', matchResultsController::class);
Route::post('login', [LoginController::class, 'login']);
Route::get('/user', function () {
    // ...
})->middleware('auth:api');

Route::middleware('auth:api')->group(function(){
    Route::get('/showPlayers',[UserController::class, 'show']);
    Route::post('/logout',[LoginController::class, 'logout']);
});
