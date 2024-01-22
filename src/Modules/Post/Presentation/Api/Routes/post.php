<?php declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Post\Presentation\Api\Controllers\CommentPostController;
use Modules\Post\Presentation\Api\Controllers\CreatePostController;
use Modules\Post\Presentation\Api\Controllers\LikePostController;
use Modules\Post\Presentation\Api\Controllers\PostQueryController;
use Modules\Post\Presentation\Api\Controllers\SharePostController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/post', CreatePostController::class)->name('create');
    Route::post('/post/like', LikePostController::class)->name('like');
    Route::post('/post/comment', CommentPostController::class)->name('comment');
    Route::post('/post/share', SharePostController::class)->name('share');
});

Route::get('/post/{postId}', [PostQueryController::class, 'getPost'])
->name('get');
