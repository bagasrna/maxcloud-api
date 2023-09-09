<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;

Route::group(['prefix' => 'auth' ,'middleware' => 'guest'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['prefix' => 'auth' ,'middleware' => 'user'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'products', 'as' => 'product.'], function () {
    Route::group(['middleware' => 'user'], function () {
        Route::get('/', [ProductController::class, 'getAll']);
        Route::get('/{id}', [ProductController::class, 'show']);
        Route::post('/create', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::delete('/delete/{id}', [ProductController::class, 'delete']);        
    });
});
