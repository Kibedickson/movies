<?php

use App\Http\Controllers\Api\MoviesController;
use App\Http\Controllers\Api\SearchController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('movies', MoviesController::class)->only('index', 'show');

Route::post('search', SearchController::class);