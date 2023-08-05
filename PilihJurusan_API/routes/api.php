<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CekLogin;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/checkToken', [AuthController::class, 'checkToken']);  
    Route::get('/foods-index', [FoodController::class, 'index']);
    Route::get('/foods', [FoodController::class, 'retrieve']);  
    Route::get('/foods/{id}', [FoodController::class, 'show']);  
    Route::post('/foods', [FoodController::class, 'store']);
    Route::put('/foods/{id}', [FoodController::class, 'update']);
    Route::delete('/foods/{id}', [FoodController::class, 'destroy']);
});