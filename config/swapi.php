<?php

use App\Models\Pivots\PivotTables;

return [

    /*
    |--------------------------------------------------------------------------
    | SWAPI database tables
    |--------------------------------------------------------------------------
    */

    'pivot_tables' => [
        PivotTables::PLANET_PERSON,
        PivotTables::FILM_PLANET,
        PivotTables::FILM_PERSON,
        PivotTables::FILM_SPECIES,
        PivotTables::FILM_VEHICLE,
        PivotTables::FILM_STARSHIP,

        PivotTables::PERSON_SPECIES,
        PivotTables::PERSON_VEHICLE,
        PivotTables::PERSON_STARSHIP,
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
