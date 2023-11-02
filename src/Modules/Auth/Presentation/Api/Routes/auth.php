<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Domain\Services\IAuthenticatedUserService;
use Modules\Auth\Presentation\Api\Controllers\RegisterController;
use Modules\Auth\Presentation\Api\Controllers\LoginController;


Route::post('/register', RegisterController::class)
    ->middleware('guest')
    ->name('register');

Route::post('/login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::get('/me', function () {
    $user = (app(IAuthenticatedUserService::class))->get();
    return response()->json($user?->toArray());
})
    ->middleware('auth:sanctum')
    ->name('');
