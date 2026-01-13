<?php

namespace App\Services\Swapi;

use App\Models\Planet;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncPlanets extends AbstractSwapiService
{
    use SwapiHelpers;

    public function sync(array $page): void
    {
        foreach ($page['results'] as $planetData) {
            $this->storeFromData($planetData);
        }
    }

    public function storeFromData(array $data): Planet
    {
        return Planet::updateOrCreate(['url' => $data['url']], $data);
    }
}
