<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchTvAction;
use App\Actions\FetchTvsAction;
use App\Http\Controllers\Controller;
use App\Services\TvService;

class TvController extends Controller
{
    public function index(): array
    {
        $tvs = FetchTvsAction::execute();

        $popularTvs = TvService::formatTvs($tvs['popularTv'], $tvs['genres']);
        $topRatedTvs = TvService::formatTvs($tvs['topRatedTv'], $tvs['genres']);

        return [
            'popularTvs' => $popularTvs,
            'topRatedTvs' => $topRatedTvs
        ];
    }

    public function show($id): array
    {
        return TvService::formatTv(FetchTvAction::execute($id));
    }
}
