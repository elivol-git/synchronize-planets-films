<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\Film;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SynchronizePlanetsProcedure
{
    const INIT_PLANETS_SOURCE = 'https://swapi.dev/api/planets/?page=1';

    protected Client $client;

    protected array $numericFields = [
        'surface_water',
        'population',
        'rotation_period',
        'orbital_period',
        'diameter',
    ];

    public function __construct()
    {
        $this->client = new \GuzzleHttp\Client([
            'timeout' => 10,
            'http_errors' => false,
//            'verify' => base_path('certs/cacert.pem'),
            'verify' => false
        ]);

    }

    public function run(): void
    {
        Log::info("Planet sync started");

        $firstPage = $this->fetchJsonWithCache(self::INIT_PLANETS_SOURCE);

        if (!$firstPage) {
            Log::warning("Planet sync aborted: no SWAPI data and no cache.");
            throw new \Exception("Planet sync failed: SWAPI unreachable and no cache");
        }
        Log::info("First page:". json_encode($firstPage).PHP_EOL);

        $this->clearTables();

        $this->syncPlanets($firstPage);

        Log::info("Planet sync completed");
    }

    protected function fetchJsonWithCache(string $url): ?array
    {
        $cacheKey = "swapi:$url";
        $cached = Cache::get($cacheKey);

        if ($cached) {
            return json_decode($cached, true);
        }

        try {
            $response = $this->client->get($url);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception("SWAPI returned status " . $response->getStatusCode());
            }

            $body = $response->getBody()->getContents();
            Cache::put($cacheKey, $body, 3600); // 1 hour
            return json_decode($body, true);

        } catch (\Throwable $e) {
            Log::error("SWAPI fetch failed for $url", ['error' => $e->getMessage()]);

            return null;
        }
    }

    protected function assertValidJson(array $json): void
    {
        if (!isset($json['results']) || !is_array($json['results'])) {
            throw new \Exception("Invalid SWAPI JSON structure");
        }
    }

    protected function clearTables(): void
    {
        Schema::disableForeignKeyConstraints();
        Film::truncate();
        Planet::truncate();
        Schema::enableForeignKeyConstraints();

        Log::info("Tables truncated");
    }

    protected function syncPlanets(array $firstPage): void
    {
        $page = $firstPage;

        while ($page) {

            foreach ($page['results'] as $planet) {
                $this->storePlanetWithFilms($planet);
            }

            $next = $page['next'] ?? null;

            if ($next) {
                $page = $this->fetchJsonWithCache($next);
            } else {
                break;
            }
        }
    }

    protected function storePlanetWithFilms(array $planetData): void
    {
        $films = $planetData['films'] ?? [];
        unset($planetData['residents'], $planetData['films']);

        foreach ($this->numericFields as $field) {
            if (!isset($planetData[$field]) || !is_numeric($planetData[$field])) {
                unset($planetData[$field]);
            }
        }

        $planet = Planet::create($planetData);

        foreach ($films as $filmUrl) {
            $this->storeFilm($filmUrl, $planet->id);
        }
    }

    protected function storeFilm(string $filmUrl, int $planetId): void
    {
        $filmData = $this->fetchJsonWithCache($filmUrl);

        unset(
            $filmData['characters'],
            $filmData['planets'],
            $filmData['starships'],
            $filmData['vehicles'],
            $filmData['species']
        );

        $filmData['planet_id'] = $planetId;

        Film::create($filmData);
    }
}
