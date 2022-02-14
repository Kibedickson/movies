<?php

use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\TvController;
use Illuminate\Support\Facades\Route;

Route::get('movies', [MoviesController::class, 'index']);
Route::get('movies/{id}', [MoviesController::class, 'show']);

Route::get('tvs', [TvController::class, 'index']);
Route::get('tvs/{id}', [TvController::class, 'show']);

Route::post('search', SearchController::class);