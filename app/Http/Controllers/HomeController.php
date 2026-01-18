<?php

namespace App\Http\Controllers;

use App\Models\Planet;

class HomeController extends Controller
{
    public function index()
    {
        $planets = Planet::with([
            'films.vehicles',
            'films.species',
            'films.starships',
            'people.vehicles',
            'people.species',
            'people.starships',
        ])->paginate(12);

        return view('home', compact('planets'));
    }

}
