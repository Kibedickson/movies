<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class MoviesController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Movies/index');
    }

    public function show($id)
    {
        //
    }
}
