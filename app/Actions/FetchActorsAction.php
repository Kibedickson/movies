<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;

class FetchActorsAction
{

    public static function execute($page)
    {
        return Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/popular?page=' . $page)
            ->json()['results'];
    }

}