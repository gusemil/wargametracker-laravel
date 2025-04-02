<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PlayedMatchesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;


Route::view('/', 'home')->name('home');

Route::get('/matches', [PlayedMatchesController::class, 'index'])
    ->name('matches.index')->middleware('auth');;

Route::get('/matches/create', [PlayedMatchesController::class, 'create'])
    ->name('matches.create')->middleware('auth');

Route::post('/matches/store', [PlayedMatchesController::class, 'store'])
    ->name('matches.store')->middleware('auth');

Route::get('/matches/{id}', [PlayedMatchesController::class, 'show'])
    ->name('matches.show');

Route::get('/matches/{match}/edit', [PlayedMatchesController::class, 'edit'])
    ->name('matches.edit');

Route::patch('/matches/{match}', [PlayedMatchesController::class, 'update'])
    ->name('matches.update');

Route::delete('/matches/{match}', [PlayedMatchesController::class, 'destroy'])
    ->name('matches.destroy');

Route::get('/players', [PlayerController::class, 'index'])
    ->name('players.index')->middleware('auth');

Route::get('/players/{id}', [PlayerController::class, 'show'])
    ->name('players.show');

Route::get('/register', [RegisterController::class, 'register'])
    ->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])
    ->name('register.store')->middleware('guest');

Route::get('/login', [LoginController::class, 'login'])
    ->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])
    ->name('login.authenticate')->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('login.logout')->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard.index')->middleware('auth');


Route::fallback(function () {
    return redirect()->route('home')->with('error', 'Something went wrong');
});
