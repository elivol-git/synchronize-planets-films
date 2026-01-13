<?php

namespace App\Services\Swapi;

use App\Models\Film;
use App\Services\Swapi\Concerns\SwapiHelpers;
use App\Services\Swapi\Relationships\SwapiRelationshipHandler;

class SyncFilms extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Film
    {
        $data = $this->fetchJsonWithCache($url);

        return $this->storeFromData($data);
    }

    public function storeFromData(array $data): Film
    {
        if (empty($data['url'])) {
            throw new \LogicException('Film URL is required for sync');
        }

        return Film::updateOrCreate(['url' => $data['url']], $data);
    }
}
