<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class ActorsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Actors/index');
    }

    public function show($id): Response
    {
        return Inertia::render('Actors/show', ['id' => $id]);
    }
}
