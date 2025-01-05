<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Post\PostImage\PostImageController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\VerifyApplicationToken;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['Ping' => 'Pong']);
})->middleware(['api', VerifyApplicationToken::class]);

Route::prefix('/users')->middleware(['api', VerifyApplicationToken::class])->group(function () {
    Route::post('/register', [UserController::class, 'addUser'])->name('users.register');
    Route::post('/login', [AuthController::class, 'login'])->name('users.login');
})->name('users');

Route::prefix('/profiles')->middleware(['api', VerifyApplicationToken::class])->group(function () {
    Route::post('/my', [ProfileController::class, 'getProfileData'])->name('profile.my');
    Route::patch('/update', [ProfileController::class, 'updateUserProfile'])->name('profile.update');
})->name('profiles');

Route::prefix('/posts')->middleware(['api', VerifyApplicationToken::class])->group(function () {
    Route::get('/all', [PostController::class, 'getPosts'])->name('post.all');
    Route::get('/{id}', [PostController::class, 'getPostById'])->name('post.show');
    Route::post('/create', [PostController::class, 'store'])->name('post.create');
    Route::patch('/update', [PostController::class, 'update'])->name('post.update');
    Route::delete('/delete', [PostController::class, 'remove'])->name('post.delete');

    Route::prefix('/images')->middleware(['api', VerifyApplicationToken::class])->group(function () {
        Route::get('/{id}', [PostImageController::class, 'getPostImageById'])->name('post.image.show');
        Route::post('/create', [PostImageController::class, 'store'])->name('post.image.create');
        Route::patch('/update', [PostImageController::class, 'update'])->name('post.image.update');
        Route::delete('/delete', [PostImageController::class, 'remove'])->name('post.image.delete');
    })->name('images');

})->name('posts');

Route::prefix('/likes')->middleware(['api', VerifyApplicationToken::class])->group(function () {
    Route::post('/add', [LikeController::class, 'addLike'])->name('like.add');
    Route::post('/count', [LikeController::class, 'checkLikesCount'])->name('like.count');
    Route::delete('/remove', [LikeController::class, 'removeLike'])->name('like.remove');
})->name('likes');
