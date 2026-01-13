<?php

namespace App\Services\Swapi;

use App\Models\Vehicle;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncVehicles extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Vehicle
    {
        $data = $this->fetchJsonWithCache($url);

        return $this->storeFromData($data);
    }

    public function storeFromData(array $data): Vehicle
    {
        return Vehicle::updateOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
