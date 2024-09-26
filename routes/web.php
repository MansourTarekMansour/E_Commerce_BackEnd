<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PermissionController;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    // Route::resource('permissions', PermissionController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);

    Route::post('/categories/store-ajax', [CategoryController::class, 'storeAjax'])->name('categories.storeAjax');
    Route::post('/brands/store-ajax', [BrandController::class, 'storeAjax'])->name('brands.storeAjax');
    
    Route::delete('/products/files/{file}', [ProductController::class, 'destroyFile'])->name('products.files.destroy');
    Route::post('products/{product}/upload-image', [ProductController::class, 'uploadImage'])->name('products.uploadImage');

});