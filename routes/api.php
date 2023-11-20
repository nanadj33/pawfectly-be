<?php

use App\Http\Controllers\HospitalController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/hospitals', 'middleware' => ['auth:sanctum']], function(){
    Route::get('', [HospitalController::class, 'hospital']);
    Route::post('', [HospitalController::class, 'store']);
    Route::put('/{hospital}', [HospitalController::class, 'update']);
    Route::delete('/{hospital}', [HospitalController::class, 'delete']);
});

Route::post('/register', [UserController::class, 'register']);

Route::post('/login', [UserController::class, 'login']);

Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
