<?php

use App\Http\Controllers\API\PassportAuthController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Passport authentication routes
    Route::controller(PassportAuthController::class)->group(function () {
        Route::post('login', 'login');
    });
// Passport authentication routes


// Auth logout routes
    Route::middleware(['auth:api'])->group(function(){
        Route::controller(PassportAuthController::class)->group(function () {
            Route::post('logout', 'logout');
        });
    });
// Auth logout routes


// Product routes
    Route::middleware(['auth:api'])->group(function(){
        Route::controller(ProductController::class)->prefix('products')->group(function () {
            Route::post('/create', 'create');
            Route::get('/view/{product}', 'view');
            Route::post('/update/{product}', 'update');
            Route::get('/delete/{product}', 'delete');
        });
    });
// Product routes
