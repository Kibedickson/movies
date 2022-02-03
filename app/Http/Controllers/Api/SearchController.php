<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SearchController extends Controller
{
    public function __invoke(Request $request): Collection
    {
        $request->validate([
            'search' => 'required|string',
        ]);

        $moviesResults = [];
        $tvResults = [];

        $results = [];

        if (strlen($request['search']) > 3) {
            $moviesResults = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/movie?query=' . $request['search'])
                ->json()['results'];

            $tvResults = Http::withToken(config('services.tmdb.token'))
                ->get('https://api.themoviedb.org/3/search/tv?query=' . $request['search'])
                ->json()['results'];
        }

        $results = array_merge($moviesResults, $tvResults);

        return collect($results)->take(5);

    }
}
