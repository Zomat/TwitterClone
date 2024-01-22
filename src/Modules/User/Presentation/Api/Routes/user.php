<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\User\Presentation\Api\Controllers\EditUserProfileController;
use Modules\User\Presentation\Api\Controllers\FollowUserController;
use Modules\User\Presentation\Api\Controllers\RegisterController;
use Modules\User\Presentation\Api\Controllers\LoginController;
use Modules\User\Presentation\Api\Controllers\UserQueryController;


Route::post('/register', RegisterController::class)
    ->middleware('guest')
    ->name('register');

Route::post('/login', LoginController::class)
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', function () {
        $user = (app(\Modules\Shared\Services\IAuthenticatedUserService::class))->get();
        return response()->json($user?->toArray());
    })
    ->name('me');

    Route::post('/user/follow/', FollowUserController::class)
    ->name('follow');

    Route::post('/user/edit-profile/', EditUserProfileController::class)
    ->name('edit-profile');
});

Route::get('/user/profile/{profileId}', [UserQueryController::class, 'getUserProfile'])
->name('profile');
