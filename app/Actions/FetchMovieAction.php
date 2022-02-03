<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class FetchMovieAction
{
    public static function execute($id)
    {
        $movie =  Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/movie/' . $id . '?append_to_response=credits,videos,images')
            ->json();

        return collect($movie);
    }
}