<?php

namespace App\Services;

use App\Services\Swapi\AbstractSwapiService;
use App\Services\Swapi\Concerns\SwapiHelpers;
use App\Services\Swapi\Database\SwapiDatabaseReset;
use App\Services\Swapi\SyncFilms;
use App\Services\Swapi\SyncPlanets;
use Log;
use Mockery\Exception;

class SynchronizeStarWarsProcedure extends AbstractSwapiService
{
    use SwapiHelpers;
    const INIT_PLANETS_SOURCE = 'https://swapi.dev/api/planets/?page=1';
    public function run(): void
    {
        Log::info('Planet sync started');

        $firstPage = $this->fetchJsonWithCache(self::INIT_PLANETS_SOURCE);
        if(!$firstPage) {
            throw new Exception("Swapi is unavailable");
        }
        $this->assertValidJson($firstPage);

        (new SwapiDatabaseReset())->reset();

        $planets = new SyncPlanets();
        $films = new SyncFilms();

        $page = $firstPage;

        while ($page) {
            foreach ($page['results'] as $planetData) {
                $planet = $planets->store($planetData);

                foreach ($planetData['films'] ?? [] as $filmUrl) {
                    $film = $films->store($filmUrl);
                    $planet->films()->syncWithoutDetaching($film->id);
                }
            }

            $page = $page['next']
                ? $this->fetchJsonWithCache($page['next'])
                : null;
        }

        Log::info('Planet sync completed');
    }

}
