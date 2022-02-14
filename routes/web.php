<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\TvController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movies.show');

Route::get('tv', [TvController::class, 'index'])->name('tvs.index');
Route::get('tv/{id}', [TvController::class, 'show'])->name('tvs.show');

// require __DIR__.'/auth.php';
