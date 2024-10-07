<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\AddressApiController;
use App\Http\Controllers\Api\CommentApiController;
use App\Http\Controllers\Api\PaymentApiController;
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

// Products Routes & Comments on Producs
Route::group(['prefix' => 'products', 'middleware' => ['auth:api']], function () {
    Route::get('/', [ProductApiController::class, 'index']); // Get all products
    Route::get('/show/{id}', [ProductApiController::class, 'show']); // Get a specific product
    Route::post('/{product}/comments/store', [CommentApiController::class, 'store']); // Add New Comment to product
    Route::post('/{product}/comments/update/{id}', [CommentApiController::class, 'update']); // Update Comment From product
    Route::delete('/{product}/comments/delete/{id}', [CommentApiController::class, 'destroy']); // DeleteComment From product
});

// Cart Routes 
Route::group(['prefix' => 'carts', 'middleware' => ['auth:api']], function () {
    Route::get('/', [CartApiController::class, 'index']);  // Get all Items in Cart
    Route::post('/add-item', [CartApiController::class, 'addItem']); // Add new Item
    Route::Post('/update-item/{cartItem}', [CartApiController::class, 'updateItem']); // Update Items quantity 
    Route::delete('/remove-item/{cartItem}', [CartApiController::class, 'removeItem']); // Remove Item
});

// Orders Routes
Route::group(['prefix' => 'orders', 'middleware' => ['auth:api']], function () {
    Route::get('/', [OrderApiController::class, 'index']);   // Get all orders
    Route::post('/', [OrderApiController::class, 'store']);  // Create a new order
    Route::get('/{order}', [OrderApiController::class, 'show']); // Get a specific order by ID
    Route::post('/{order}/status/{status}', [OrderApiController::class, 'updateStatus']); // Update the status of an order
});

// Addresses Routes
Route::group(['prefix' => 'addresses', 'middleware' => ['auth:api']], function () {
    Route::get('/', [AddressApiController::class, 'index']);  // Get all addresses
    Route::post('/store', [AddressApiController::class, 'store']);  // Store a new address
    Route::post('/update/{address}', [AddressApiController::class, 'update']);  // Update an address
    Route::delete('/delete/{address}', [AddressApiController::class, 'destroy']);  // Delete an address
});

// Payment Routes
Route::group(['prefix' => 'payments', 'middleware' => ['auth:api']], function () {
    Route::get('/', [PaymentApiController::class, 'index']); // Get all payments
    Route::post('/', [PaymentApiController::class, 'store']); // Create a new payment
    Route::get('/{payment}', [PaymentApiController::class, 'show']); // Get a specific payment
});