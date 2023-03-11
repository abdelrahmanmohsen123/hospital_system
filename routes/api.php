<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\FilterReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ReservationController;

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



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::post('register',[AuthController::class,'createUser']);
    Route::post('login',[AuthController::class,'loginUser']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::apiResource('reservations', ReservationController::class)->middleware('auth:sanctum');
    Route::get('myreservations', [ReservationController::class, 'my_reservations'])->middleware('auth:sanctum');

});