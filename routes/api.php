<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//API route for register new user
Route::post('/register', [App\Http\Controllers\API\AuthController::class, 'register']);
//API route for login user
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', function(Request $request) {
        return auth()->user();
    });


    Route::get('/v2/movies/', [App\Http\Controllers\MovieController::class, 'index'])->name('api.movies');
    Route::get('/v2/movies/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->name('api.info');

    Route::post('/v2/create', [App\Http\Controllers\MovieController::class, 'store'])->name('api.store');
    // Route::get('/v2/edit/{movie}', [App\Http\Controllers\MovieController::class, 'edit'])->name('movies.edit');
    Route::patch('/v2/update/{movie}', [App\Http\Controllers\MovieController::class, 'update'])->name('api.update');
    Route::delete('/v2/delete/{movie}', [App\Http\Controllers\MovieController::class, 'destroy'])->name('api.destroy');

    Route::get('/tmdb/movies', [App\Http\Controllers\MovieController::class, 'fetchMoviesFromTMDb'])->name('api.tmdb.movies');
    Route::get('/tmdb/movies/{movie}', [App\Http\Controllers\MovieController::class, 'fetchMovieFromTMDb'])->name('api.fetch.movie');
    Route::get('/swapi/movies', [App\Http\Controllers\MovieController::class, 'fetchMoviesFromswapi'])->name('api.swapi.movies');

    // API route for logout user
    Route::post('/logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
});
