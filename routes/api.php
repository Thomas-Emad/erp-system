<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FactoryController;
use App\Http\Controllers\Api\StoreController;

// User Auth
Route::group(['prefix' => 'auth', 'middleware' => 'guest'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group(['middleware' => 'JwtAuth'], function () {
    // User Auth
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/profile', [AuthController::class, 'profile']);
    });

    // Roles
    Route::apiResource('/roles', RoleController::class);
    Route::get('/role/getAllPremission', [RoleController::class, 'getAllPremission']);

    // Factories
    Route::apiResource('/factories', FactoryController::class);

    // Stores
    Route::apiResource('/stores', StoreController::class);
});
