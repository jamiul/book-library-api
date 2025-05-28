<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BookshelfController;

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

    // Bookshelf CRUD
    Route::apiResource('bookshelves', BookshelfController::class);

    // Book CRUD & Search
    Route::get('books/search', [BookController::class, 'search'])
        ->name('books.search');
    Route::apiResource('books', BookController::class);
});
