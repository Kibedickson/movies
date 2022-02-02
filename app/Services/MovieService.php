<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class MovieService
{

    public static function formatGenres($genres): Collection
    {
        return collect($genres)->mapWithKeys(fn($genre) => [$genre['id'] => $genre['name']]);
    }

    public static function formatMovies($movies, $genres): Collection
    {
        return collect($movies)
            ->sortByDesc('vote_average')
            ->take(10)
            ->values()
            ->map(function ($movie) use ($genres) {
                $genres = collect($movie['genre_ids'])->mapWithKeys(function ($genre) use ($genres) {
                    return [$genre => self::formatGenres($genres)->get($genre)];
                })->implode(', ');

                return [
                    'id' => $movie['id'],
                    'title' => $movie['title'],
                    'overview' => $movie['overview'],
                    'poster_path' => 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path'],
                    'vote_average' => $movie['vote_average'] * 10 . '%',
                    'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
                    'genres' => $genres
                ];
            });
    }
}