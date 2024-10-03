<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {

  Route::get('thomas/login', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

  Route::post('thomas/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {

  Route::put('password', [PasswordController::class, 'update'])->name('password.update');

  Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
});
