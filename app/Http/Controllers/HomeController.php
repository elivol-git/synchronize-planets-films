<?php

namespace App\Http\Controllers;

use App\Models\Planet;

class HomeController extends Controller
{
    public function index()
    {
        $planets = Planet::with('films')->paginate(10);

        return view('home', compact('planets'));
    }
}
