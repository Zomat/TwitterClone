<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Controllers\RegisterController;
use Modules\Auth\Controllers\LoginController;

Route::post('/register', RegisterController::class)
    ->middleware('guest')
    ->name('register');

Route::post('/login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::get('/me', function () {
    dd(Auth::user());
})
    ->middleware('auth:sanctum')
    ->name('');
