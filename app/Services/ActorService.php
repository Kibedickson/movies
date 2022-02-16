<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class ActorService
{
    public static function formatActors($actors): Collection
    {
        return collect($actors)->map(function ($actor) {
            return collect($actor)->merge([
                'profile_path' => $actor['profile_path']
                    ? 'https://image.tmdb.org/t/p/w235_and_h235_face' . $actor['profile_path']
                    : 'https://ui-avatars.com/api/?size=235&name=' . $actor['name'],
                'known_for' => collect($actor['known_for'])->where('media_type', 'movie')->pluck('title')->union(
                    collect($actor['known_for'])->where('media_type', 'tv')->pluck('name')
                )->implode(', '),
            ])->only([
                'name', 'id', 'profile_path', 'known_for',
            ]);
        });
    }

    public static function previous($page): ?int
    {
        return $page > 1 ? $page - 1 : null;
    }

    public static function next($page): ?int
    {
        return $page < 500 ? $page + 1 : null;
    }

    public static function formatActor($actor): Collection
    {
        return collect($actor)->merge([
            'birthday' => Carbon::parse($actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($actor['birthday'])->age,
            'profile_path' => $actor['profile_path']
                ? 'https://image.tmdb.org/t/p/w300/' . $actor['profile_path']
                : 'https://via.placeholder.com/300x450',
        ])->only([
            'birthday', 'age', 'profile_path', 'name', 'id', 'homepage', 'place_of_birth', 'biography'
        ]);
    }

    public static function formatSocial($social): Collection
    {
        return collect($social)->merge([
            'twitter' => $social['twitter_id'] ? 'https://twitter.com/'.$social['twitter_id'] : null,
            'facebook' => $social['facebook_id'] ? 'https://facebook.com/'.$social['facebook_id'] : null,
            'instagram' => $social['instagram_id'] ? 'https://instagram.com/'.$social['instagram_id'] : null,
        ])->only([
            'facebook', 'instagram', 'twitter',
        ]);
    }

    public static function formatCredits($credits): Collection
    {
        $castMovies = collect($credits)->get('cast');

        return collect($castMovies)->map(function($movie) {
            if (isset($movie['release_date'])) {
                $releaseDate = $movie['release_date'];
            } elseif (isset($movie['first_air_date'])) {
                $releaseDate = $movie['first_air_date'];
            } else {
                $releaseDate = null;
            }

            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'release_date' => $releaseDate,
                'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                'title' => $title,
                'character' => $movie['character'] ?? '',
                'linkToPage' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : route('tvs.show', $movie['id']),
            ])->only([
                'release_date', 'release_year', 'title', 'character', 'linkToPage',
            ]);
        })->sortByDesc('release_date');
    }

    public static function knownForMovies($credits): Collection
    {
        $castMovies = collect($credits)->get('cast');

        return collect($castMovies)->sortByDesc('popularity')->take(5)->map(function($movie) {
            if (isset($movie['title'])) {
                $title = $movie['title'];
            } elseif (isset($movie['name'])) {
                $title = $movie['name'];
            } else {
                $title = 'Untitled';
            }

            return collect($movie)->merge([
                'poster_path' => $movie['poster_path']
                    ? 'https://image.tmdb.org/t/p/w185'.$movie['poster_path']
                    : 'https://via.placeholder.com/185x278',
                'title' => $title,
                'linkToPage' => $movie['media_type'] === 'movie' ? route('movies.show', $movie['id']) : route('tvs.show', $movie['id'])
            ])->only([
                'poster_path', 'title', 'id', 'media_type', 'linkToPage',
            ]);
        });
    }
}