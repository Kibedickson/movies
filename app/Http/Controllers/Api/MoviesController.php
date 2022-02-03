<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchMovieAction;
use App\Actions\FetchMoviesAction;
use App\Http\Controllers\Controller;
use App\Services\MovieService;

class MoviesController extends Controller
{
    public function index(): array
    {
        $movies = FetchMoviesAction::execute();

        $popularMovies = MovieService::formatMovies($movies['popularMovies'], $movies['genres']);
        $nowPlayingMovies = MovieService::formatMovies($movies['nowPlayingMovies'], $movies['genres']);

        return [
            'popularMovies' => $popularMovies,
            'nowPlayingMovies' => $nowPlayingMovies,
        ];
    }

    public function show($id): array
    {
        return MovieService::formatMovie(FetchMovieAction::execute($id));

    }
}
