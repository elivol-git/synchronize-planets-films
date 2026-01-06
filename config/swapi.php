<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SWAPI database tables
    |--------------------------------------------------------------------------
    */

    'pivot_tables' => [
        'film_planet',
        'film_person',
        'film_species',
        'film_vehicle',
        'film_starship',

        'person_species',
        'person_vehicle',
        'person_starship',
    ],

    'models' => [
        App\Models\Film::class,
        App\Models\Planet::class,
        App\Models\Person::class,
        App\Models\Species::class,
        App\Models\Vehicle::class,
        App\Models\Starship::class,
    ],
];
