<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return response()->json(['Ping' => 'Pong']);
});

Route::prefix('/users')->middleware('api')->group(function () {
    Route::post('/register', [UserController::class, 'addUser'])->name('users.register');
    Route::post('/login', [AuthController::class, 'login'])->name('users.login');
})->name('users');



