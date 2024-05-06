<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;


Route::name('frontend.')->group(function () {
    Route::get('/', [HomeController::class, 'homepage'])->name('homepage');
    Route::get('products/{product}', [HomeController::class, 'singleProduct'])->name('single_product');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('dashboard', DashboardController::class)->only('index');

    Route::resource('users', UserController::class)->except(['create']);
    Route::post('users/filter', [UserController::class, 'filter'])->name('users.filter');

    Route::resource('profile', ProfileController::class)->only('index', 'update');

    Route::resource('categories', CategoryController::class)->except(['create']);
    Route::post('categories/filter', [CategoryController::class, 'filter'])->name('categories.filter');

    Route::resource('products', ProductController::class)->except(['create']);
    Route::post('products/filter', [ProductController::class, 'filter'])->name('products.filter');
});


require __DIR__.'/auth.php';