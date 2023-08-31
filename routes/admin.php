<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('admin')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);


    // Route::post('/login', [AdminAuthController::class, 'login']);

    Route::middleware(['auth:sanctum', 'isAdmin'])->group(function () {
        Route::get('/checkingAuthenticated', function () {
            return response()->json(['message' => "You are in", "status" => 200], 200);
        });


        Route::get('/movies/{id}', [MovieController::class, 'show']);
        Route::get('/movies', [MovieController::class, 'index']);

        Route::resource('/movies', MovieController::class)->only(['store', 'update', 'destroy']);
        Route::get('/users/{id}/movies', [UserMovieController::class, 'index'])->name('users.movies.index');
        Route::post('/logout', [AuthController::class, 'logout']);

        //Route::resource('users.posts', UserMovieController::class);

        Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
});
