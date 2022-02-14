<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class FetchMovieAction
{
    public static function execute($id)
    {
        $tvshow = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/tv/'.$id.'?append_to_response=credits,videos,images')
            ->json();

        return collect($tvshow);
    }
}