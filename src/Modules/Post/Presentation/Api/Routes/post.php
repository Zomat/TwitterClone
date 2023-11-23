<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Post\Presentation\Api\Controllers\CreatePostController;

Route::post('/post', CreatePostController::class)
    ->middleware('auth:sanctum')
    ->name('create');
