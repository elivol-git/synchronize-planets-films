<?php

namespace App\Services\Swapi;

use App\Models\Species;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncSpecies extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Species
    {
        $data = $this->fetchJsonWithCache($url);

        return $this->storeFromData($data);
    }

    public function storeFromData(array $data): Species
    {
        return Species::updateOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
