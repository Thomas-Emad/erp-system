<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\FeedbackController;

Route::get('/', [HomeController::class, '__invoke'])->name('home');


Route::group(['middleware' => 'auth', 'prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
  Route::view('/', 'pannel.dashboard')->name('index');

  Route::resource('/projects', ProjectController::class);
  Route::resource('/feedbacks', FeedbackController::class);
});

Route::get('project/{id}', [ProjectController::class, 'show'])->name('project.show');


require __DIR__ . '/auth.php';
