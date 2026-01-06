<?php

namespace App\Services\Swapi;

use App\Models\Film;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncFilms extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Film
    {
        $data = $this->fetchJsonWithCache($url);

        unset(
            $data['characters'],
            $data['planets'],
            $data['species'],
            $data['vehicles'],
            $data['starships']
        );

        return Film::firstOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
