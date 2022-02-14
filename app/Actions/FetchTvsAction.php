<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class FetchTvsAction
{

    public static function execute(): array
    {
        $popularTv = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/popular')
            ->json()['results'];

        $topRatedTv = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/top_rated')
            ->json()['results'];

        $genres = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/genre/tv/list')
            ->json()['genres'];

        return [
            'popularTv' => $popularTv,
            'topRatedTv' => $topRatedTv,
            'genres' => $genres,
        ];
    }

}