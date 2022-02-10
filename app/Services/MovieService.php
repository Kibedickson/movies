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

    public static function formatMovie($movie): array
    {
        return [
            'poster_path' => $movie['poster_path']
                ? 'https://image.tmdb.org/t/p/w500/' . $movie['poster_path']
                : 'https://via.placeholder.com/500x750',
            'id' => $movie,
            'genres' => collect($movie['genres'])->pluck('name')->flatten()->implode(', '),
            'title' => $movie['title'],
            'vote_average' => $movie['vote_average'] * 10 . '%',
            'overview' => $movie['overview'],
            'release_date' => Carbon::parse($movie['release_date'])->format('M d, Y'),
            'credits' => $movie['credits'],
            'videos' => $movie['videos'],
            'images' => collect($movie['images']['backdrops'])->sortByDesc('vote_average')->take(9)->values(),
            'crew' => collect($movie['credits']['crew'])->take(2),
            'cast' => collect($movie['credits']['cast'])->sortBy('order')->take(5)->values()->map(function ($cast) {
                return collect($cast)->merge([
                    'profile_path' => $cast['profile_path']
                        ? 'https://image.tmdb.org/t/p/w300' . $cast['profile_path']
                        : 'https://via.placeholder.com/300x450',
                ]);
            }),
        ];
    }
}