<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(['auth'])->name('home');
Route::get('/show/{movie}', [App\Http\Controllers\HomeController::class, 'show'])->middleware(['auth'])->name('movies.show');
Route::get('/edit/{movie}', [App\Http\Controllers\HomeController::class, 'edit'])->middleware(['auth'])->name('movies.edit');

Route::get('/api/v1/movies/', [App\Http\Controllers\MovieController::class, 'index'])->middleware(['auth'])->name('movies');
Route::get('/api/v1/movies/{movie}', [App\Http\Controllers\MovieController::class, 'show'])->middleware(['auth'])->name('movie.info');

Route::post('/api/v1/create', [App\Http\Controllers\MovieController::class, 'store'])->middleware(['auth'])->name('movies.store');
// Route::get('/api/v1/edit/{movie}', [App\Http\Controllers\MovieController::class, 'edit'])->middleware(['auth'])->name('movies.edit');
Route::patch('/api/v1/update/{movie}', [App\Http\Controllers\MovieController::class, 'update'])->middleware(['auth'])->name('movies.update');
Route::delete('/api/v1/delete/{movie}', [App\Http\Controllers\MovieController::class, 'destroy'])->middleware(['auth'])->name('movies.destroy');

Route::get('/tmdb/movies', [App\Http\Controllers\MovieController::class, 'fetchMoviesFromTMDb'])->middleware(['auth'])->name('tmdb.movies');
Route::get('/tmdb/movies/{movie}', [App\Http\Controllers\MovieController::class, 'fetchMovieFromTMDb'])->middleware(['auth'])->name('fetch.movie');
Route::get('/swapi/movies', [App\Http\Controllers\MovieController::class, 'fetchMoviesFromswapi'])->middleware(['auth'])->name('swapi.movies');


// For Test Purpose
Route::get('/api/movies', [App\Http\Controllers\MovieController::class, 'index'])->name('testmovies');
Route::patch('/api/movies/{movie}', [App\Http\Controllers\MovieController::class, 'update'])->name('movies.testupdate');
Route::delete('/api/movies/{movie}', [App\Http\Controllers\MovieController::class, 'destroy'])->name('movies.testdelete');
