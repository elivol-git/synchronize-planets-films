<?php

namespace App\Http\Controllers;

use App\Models\Planet;
use Carbon\Carbon;

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

        $lastUpdated = Planet::max('updated_at');
        $lastUpdated = $lastUpdated ? Carbon::parse($lastUpdated) : null;

        return view('home', compact('planets', 'lastUpdated'));
    }

}
