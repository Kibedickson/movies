<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MoviesController::class, 'index'])->name('movies.index');
Route::get('/movies/{id}', [MoviesController::class, 'show'])->name('movies.show');

// require __DIR__.'/auth.php';
