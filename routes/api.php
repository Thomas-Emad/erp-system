<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\FactoryController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\RawMaterialController;

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
    
    // Product Controller
    Route::group(['prefix' => 'products'], function () {
        Route::get('/index', [ProductController::class, 'index']);
        Route::post('/store', [ProductController::class, 'store']);
        Route::put('/update/{id}', [ProductController::class, 'update']);
        Route::get('/show/{id}', [ProductController::class, 'show']);
        Route::get('/destroy', [ProductController::class, 'destroy']);
    });

    // Machine Controller
    Route::group(['prefix' => 'machines'], function () {
        Route::get('/index', [MachineController::class, 'index']);
        Route::get('/show/{id}', [MachineController::class, 'show']);
        Route::post('/store', [MachineController::class, 'store']);
        Route::put('/update/{id}', [MachineController::class, 'update']);
        Route::get('/destroy', [MachineController::class, 'destroy']);
    });

    // Raw Material Controller
    Route::group(['prefix' => 'rawmaterial'], function () {
        Route::get('/index', [RawMaterialController::class, 'index']);
        Route::get('/show/{id}', [RawMaterialController::class, 'show']);
        Route::post('/store', [RawMaterialController::class, 'store']);
        Route::put('/update/{id}', [RawMaterialController::class, 'update']);
        Route::get('/destroy', [RawMaterialController::class, 'destroy']);
    });

});

