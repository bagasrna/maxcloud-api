<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;

Route::group(['prefix' => 'auth', 'as' => 'auth.', 'middleware' => 'guest'], function () {
    Route::post('/admin-login', [AuthController::class, 'login'])->name('admin');
    Route::post('/login', [AuthController::class, 'login'])->name('user');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/admin-profile', [AuthController::class, 'getProfile'])->name('profile.admin');
        Route::get('/profile', [AuthController::class, 'getProfile'])->name('profile.user');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::post('/ban-user', [AuthController::class, 'banUser'])->name('banned');
    });
});

Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
    Route::group(['middleware' => 'user'], function () {
        Route::get('/', [ProductController::class, 'getAll'])->name('get.all');
        Route::get('/{id}', [ProductController::class, 'show'])->name('detail');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::post('/create', [ProductController::class, 'store'])->name('create');
        Route::patch('/update/{product:id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product:id}', [ProductController::class, 'delete'])->name('delete');
    });
});

Route::group(['prefix' => 'orders', 'as' => 'order.'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::post('/validate', [OrderController::class, 'validateOrder'])->name('validate');
    });
    Route::group(['middleware' => 'user'], function () {
        Route::get('/', [OrderController::class, 'getAll'])->name('get.all');
        Route::post('/create', [OrderController::class, 'store'])->name('create');
    });
});
