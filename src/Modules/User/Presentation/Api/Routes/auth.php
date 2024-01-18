<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Presentation\Api\Controllers\RegisterController;
use Modules\User\Presentation\Api\Controllers\LoginController;


Route::post('/register', RegisterController::class)
    ->middleware('guest')
    ->name('register');

Route::post('/login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::get('/me', function () {
    $user = (app(\Modules\Shared\Services\IAuthenticatedUserService::class))->get();
    return response()->json($user?->toArray());
})
    ->middleware('auth:sanctum')
    ->name('');
