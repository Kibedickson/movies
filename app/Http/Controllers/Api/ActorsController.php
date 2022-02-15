<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchActorAction;
use App\Actions\FetchActorsAction;
use App\Http\Controllers\Controller;
use App\Services\ActorService;

class ActorsController extends Controller
{
    public function index($page = 1)
    {
        abort_if($page > 500, 204);

        $actors = ActorService::formatActors(FetchActorsAction::execute($page));

        return [
            'actors' => $actors,
            'previous' => ActorService::previous($page),
            'next' => ActorService::next($page)
        ];
    }

    public function show($id)
    {
        [$actor, $social, $credits] = FetchActorAction::execute($id);


    }
}
