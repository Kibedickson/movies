<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class TvService
{

    public static function formatGenres($genres): Collection
    {
        return collect($genres)->mapWithKeys(fn($genre) => [$genre['id'] => $genre['name']]);
    }

    public static function formatTvs($tvs, $genres): Collection
    {

        return collect($tvs)
            ->take(10)
            ->values()
            ->map(function ($tv) use ($genres) {
                $genres = collect($tv['genre_ids'])->mapWithKeys(function ($genre) use ($genres) {
                    return [$genre => self::formatGenres($genres)->get($genre)];
                })->implode(', ');

                return [
                    'id' => $tv['id'],
                    'name' => $tv['name'],
                    'overview' => $tv['overview'],
                    'poster_path' => 'https://image.tmdb.org/t/p/w500/' . $tv['poster_path'],
                    'vote_average' => $tv['vote_average'] * 10 . '%',
                    'first_air_date' => Carbon::parse($tv['first_air_date'])->format('M d, Y'),
                    'genres' => $genres,
                    'genre_ids' => $tv['genre_ids'],
                ];
            });
    }

    public static function formatTv($tv): array
    {
        return [
            'poster_path' => $tv['poster_path']
                ? 'https://image.tmdb.org/t/p/w500/' . $tv['poster_path']
                : 'https://via.placeholder.com/500x750',
            'id' => $tv,
            'genres' => collect($tv['genres'])->pluck('name')->flatten()->implode(', '),
            'name' => $tv['name'],
            'vote_average' => $tv['vote_average'] * 10 . '%',
            'overview' => $tv['overview'],
            'first_air_date' => Carbon::parse($tv['first_air_date'])->format('M d, Y'),
            'credits' => $tv['credits'],
            'videos' => $tv['videos'],
            'created_by' => $tv['created_by'],
            'images' => collect($tv['images']['backdrops'])->sortByDesc('vote_average')->take(9)->values(),
            'crew' => collect($tv['credits']['crew'])->take(2),
            'cast' => collect($tv['credits']['cast'])->sortBy('order')->take(5)->values()->map(function ($cast) {
                return collect($cast)->merge([
                    'profile_path' => $cast['profile_path']
                        ? 'https://image.tmdb.org/t/p/w300' . $cast['profile_path']
                        : 'https://via.placeholder.com/300x450',
                ]);
            }),
        ];
    }
}