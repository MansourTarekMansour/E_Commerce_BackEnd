<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CustomerApiController;

// Auth Routes
Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthApiController::class, 'register']);
    Route::post('login', [AuthApiController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::post('/refresh', [AuthApiController::class, 'refresh']);
    });
});

// Customer Routes
Route::group(['prefix' => 'customer', 'middleware' => ['auth:api']], function () {
    Route::get('/profile', [CustomerApiController::class, 'profile']);  // Get customer profile
    Route::post('/update', [CustomerApiController::class, 'update']);    // Update profile
    Route::delete('/delete', [CustomerApiController::class, 'destroy']); // Delete account
    Route::get('/show/{id}', [CustomerApiController::class, 'show']); // Show specific customer by ID
});

// Brands Routes
Route::group(['prefix' => 'brands', 'middleware' => ['auth:api']], function () {
    Route::get('/', [BrandApiController::class, 'index']); // Get all brands
    Route::get('/show/{id}', [BrandApiController::class, 'show']); // Get a specific brand
});

// Categories Routes
Route::group(['prefix' => 'categories', 'middleware' => ['auth:api']], function () {
    Route::get('/', [CategoryApiController::class, 'index']); // Get all categories
    Route::get('/show/{id}', [CategoryApiController::class, 'show']); // Get a specific category
});

// Products Routes
Route::group(['prefix' => 'products', 'middleware' => ['auth:api']], function () {
    Route::get('/', [ProductApiController::class, 'index']); // Get all products
    Route::get('/show/{id}', [ProductApiController::class, 'show']); // Get a specific product
});
