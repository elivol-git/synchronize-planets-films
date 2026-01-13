<?php

namespace App\Services\Swapi;

use App\Models\Starship;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncStarships extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Starship
    {
        $data = $this->fetchJsonWithCache($url);
        return $this->storeFromData($data);
    }

    public function storeFromData(array $data): Starship
    {
        return Starship::updateOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
