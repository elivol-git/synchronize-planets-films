<?php

namespace App\Services;

use App\Models\Person;
use App\Models\Planet;
use App\Models\Species;
use App\Services\Swapi\AbstractSwapiService;
use App\Services\Swapi\Concerns\SwapiHelpers;
use App\Services\Swapi\Database\SwapiDatabaseReset;
use App\Services\Swapi\Relationships\SwapiRelationshipHandler;
use App\Services\Swapi\SwapiUrlRegistry;
use App\Services\Swapi\SyncFilms;
use App\Services\Swapi\SyncPeople;
use App\Services\Swapi\SyncPlanets;
use App\Services\Swapi\SyncSpecies;
use App\Services\Swapi\SyncStarships;
use App\Services\Swapi\SyncVehicles;

class SynchronizeStarWarsProcedure extends AbstractSwapiService
{
    use SwapiHelpers;

    const PLANETS_START = 'https://swapi.dev/api/planets/?page=1';

    public function __construct(
        protected SyncPlanets $planets,
        protected SyncFilms $films,
        protected SyncPeople $people,
        protected SyncSpecies $species,
        protected SyncVehicles $vehicles,
        protected SyncStarships $starships,
        protected SwapiRelationshipHandler $relations,
        protected SwapiUrlRegistry $registry
    )
    {
        parent::__construct();
    }

    public function run(): void
    {
        $page = $this->getNextPage(self::PLANETS_START);

        (new SwapiDatabaseReset())->reset();

        $this->syncPlanetsWithRelatedEntities($page);

        $this->resolveHomeworlds();
    }

    protected function syncPlanetsWithRelatedEntities(array $page): void
    {
        while ($page) {
            foreach ($page['results'] as $planetData) {
                $this->processPlanet($planetData);
            }
            $page = $this->getNextPage($page['next'] ?? null);
        }
    }

    protected function processPlanet(array $data): void
    {
        $planet = $this->planets->storeFromData($data);
        $this->relations->syncPlanetRelations($planet, $data);

        foreach ($data['films'] ?? [] as $url) {
            $this->processEntityByUrl(
                $url,
                fn($data) => $this->films->storeFromData($data),
                fn($film, $data) => $this->relations->syncFilmRelations($film, $data)
            );
        }

        foreach ($data['residents'] ?? [] as $url) {
            $this->processEntityByUrl(
                $url,
                fn($data) => $this->people->storeFromData($data),
                fn($person, $data) => $this->relations->syncPersonRelations($person, $data)
            );
        }
    }

    protected function processEntityByUrl(string $url, callable $store, ?callable $sync = null): void
    {
        if (! $this->registry->remember($url)) {
            return;
        }

        $data = $this->fetchJsonWithCache($url);
        if (!$data) return;

        $entity = $store($data);

        if ($sync) {
            $sync($entity, $data);
        }
    }

    protected function resolveHomeworlds(): void
    {
        Person::whereNotNull('homeworld')->cursor()
            ->each(function (Person $person) {
                if ($planet = Planet::where('url', $person->homeworld)->first()) {
                    $person->homeworld()->associate($planet);
                    $person->save();
                }
            });

        Species::whereNotNull('homeworld')->cursor()
            ->each(function (Species $species) {
                if ($planet = Planet::where('url', $species->homeworld)->first()) {
                    $species->homeworld()->associate($planet);
                    $species->save();
                }
            });
    }
}
