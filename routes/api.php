<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::post('/register', [UserController::class, 'register'])
    ->name('user.register');

Route::post('/login', [LoginController::class, 'login'])
    ->name('user.login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('user.logout');

    Route::get("/user", function (Request $request) {
        return $request->user();
    });
});
