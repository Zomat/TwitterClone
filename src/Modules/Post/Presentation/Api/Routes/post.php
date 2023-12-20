<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Post\Presentation\Api\Controllers\CommentPostController;
use Modules\Post\Presentation\Api\Controllers\CreatePostController;
use Modules\Post\Presentation\Api\Controllers\LikePostController;

Route::post('/post', CreatePostController::class)
    ->middleware('auth:sanctum')
    ->name('create');

Route::post('/post/like', LikePostController::class)
    ->middleware('auth:sanctum')
    ->name('like');

Route::post('/post/comment', CommentPostController::class)
    ->middleware('auth:sanctum')
    ->name('comment');
