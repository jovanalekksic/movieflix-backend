<?php

use App\Http\Controllers\API\AdminAuthController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AuthController2;
use App\Http\Controllers\MovieController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/movies/{id}', [MovieController::class, 'show']);
// Route::get('/movies', [MovieController::class, 'index']);

// Route::resource('users.posts', UserMovieController::class);

// Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
// Route::get('/users', [UserController::class, 'index'])->name('users.index');

//Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
// Route::resource('movies', MovieController::class);
// Route::get('/movies', [MovieController::class, 'index']);

//OBICAN ULOGOVANI KORISNIK
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::get('/profile', function (Request $request) {
    //     return auth()->user();
    // });
    Route::get('/checkingAuthUser', function () {
        return response()->json(['message' => "You are in", "status" => 200], 200);
    });
    Route::get('/movies/{id}', [MovieController::class, 'show']);
    Route::get('/movies', [MovieController::class, 'index']);


    Route::post('/logout', [AuthController::class, 'logout']);
});

require __DIR__ . '/admin.php';
