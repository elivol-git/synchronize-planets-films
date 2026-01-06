<?php

namespace App\Services\Swapi;

use App\Models\Planet;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncPlanets extends AbstractSwapiService
{
    use SwapiHelpers;

    protected array $numericFields = [
        'surface_water',
        'population',
        'rotation_period',
        'orbital_period',
        'diameter',
    ];

    public function sync(array $page): void
    {
        foreach ($page['results'] as $planetData) {
            $this->store($planetData);
        }
    }

    public function store(array $data): Planet
    {
        unset($data['films'], $data['residents']);

        foreach ($this->numericFields as $field) {
            $data[$field] = is_numeric($data[$field] ?? null)
                ? $data[$field]
                : null;
        }

        return Planet::firstOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
