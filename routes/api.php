<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerController;

use App\Http\Middleware\SetLocaleLang;

// Grouping authentication routes under 'Auth'
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('profile', [CustomerController::class, 'profile']);
        Route::put('profile/update', [CustomerController::class, 'update']);
        Route::delete('profile/delete', [CustomerController::class, 'destroy']);
    });


    
})->middleware(SetLocaleLang::class);

// // Non-authentication related routes
// Route::middleware('auth:api')->group(function () {
//     
// });
