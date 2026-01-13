<?php

namespace App\Services\Swapi;

use App\Models\Person;
use App\Services\Swapi\Concerns\SwapiHelpers;

class SyncPeople extends AbstractSwapiService
{
    use SwapiHelpers;

    public function store(string $url): Person
    {
        $data = $this->fetchJsonWithCache($url);

        return $this->storeFromData($data);
    }

    public function storeFromData(array $data): Person
    {
        return Person::updateOrCreate(
            ['url' => $data['url']],
            $data
        );
    }
}
