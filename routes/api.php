<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{user}', [UserController::class, 'show']);
    Route::put('/{user}', [UserController::class, 'update']);
    Route::delete('/{user}', [UserController::class, 'destroy']);

    Route::get('/{user}/movies', [UserController::class, 'userMovies']);
    Route::post('/{user}/movies', [UserController::class, 'attachMovie']);
    Route::delete('/{user}/movies', [UserController::class, 'detachMovie']);
});

Route::prefix('movies')->group(function () {
    Route::post('/', [MovieController::class, 'store']);
    Route::put('/{movie}', [MovieController::class, 'update']);
    Route::delete('/{movie}', [MovieController::class, 'destroy']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
