<?php

namespace App\Actions;

use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\ArrayShape;

class FetchActorAction
{
    #[ArrayShape(['actor' => "array|mixed", 'social' => "array|mixed", 'credits' => "array|mixed"])]
    public static function execute($id): array
    {
        $actor = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id)
            ->json();

        $social = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '/external_ids')
            ->json();

        $credits = Http::withToken(config('services.tmdb.token'))
            ->get('https://api.themoviedb.org/3/person/' . $id . '/combined_credits')
            ->json();

        return [
            'actor' => $actor,
            'social' => $social,
            'credits' => $credits
        ];
    }
}