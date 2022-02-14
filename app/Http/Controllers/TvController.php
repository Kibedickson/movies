<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class TvController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Tv/index');
    }

    public function show($id): Response
    {
        return Inertia::render('Tv/show', ['id' => $id]);
    }
}
