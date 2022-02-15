<?php

namespace App\Services;

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
}