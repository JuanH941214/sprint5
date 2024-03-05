<?php

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PlayController;
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
Route::post('login', [LoginController::class, 'login']);
Route::post('/register', [UserController::class, 'store']);



Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[LoginController::class, 'logout']);
    Route::group(['middleware' => ['role:admin']], function(){
        Route::get('/players',[UserController::class, 'index']);
        Route::get('/players/ranking',[UserController::class, 'showRanking']);
        Route::get('/players/ranking/loser',[UserController::class, 'lowestWinRate']);
        Route::get('/players/ranking/winner',[UserController::class, 'highestWinRate']);


    });
    Route::group(['middleware' => ['role:player']], function(){
        Route::get('/players/{id}',[PlayController::class, 'show']);
        Route::post('/players/{id}/games',[PlayController::class, 'play']);
        Route::delete('/players/{id}/games',[PlayController::class, 'destroy']);
        Route::put('/players/{id}',[PlayController::class, 'update']);
    });
});


    
