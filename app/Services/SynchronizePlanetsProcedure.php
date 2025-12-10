<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\Film;
use App\Notifications\SyncFailedNotification;
use GuzzleHttp\Client;
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
        $this->client = new Client([
            'timeout' => 10,
            'http_errors' => false,
        ]);
    }

    public function run(): void
    {
        try {
            Log::info("Planet sync started");

            // 1) Safe fetch for first page (cache OR remote)
            $firstPage = $this->fetchJsonWithCache(self::INIT_PLANETS_SOURCE);

            // 2) Validate basic JSON structure
            $this->assertValidJson($firstPage);

            // 3) NOW it's safe to clear tables
            $this->clearTables();

            // 4) Sync all pages using bootstrapped first page
            $this->syncPlanets($firstPage);

            Log::info("Planet sync completed");

        } catch (\Throwable $e) {

            \Notification::route('mail', 'elivol333@gmail.com')
                ->notify(new SyncFailedNotification($e->getMessage()));

            Log::error("Planet sync failed", [
                "error" => $e->getMessage()
            ]);

            throw $e;
        }
    }

    protected function fetchJsonWithCache(string $url): array
    {
        // 1. Try cache first — no remote hit if available
        $cached = cache()->get("swapi:$url");

        if ($cached) {
            return json_decode($cached, true);
        }

        // 2. Cache empty → fetch remote
        $response = $this->client->get($url);

        if ($response->getStatusCode() !== 200) {
            // If remote fails AND no cache → job must stop
            throw new \Exception("SWAPI unreachable and no cached data available");
        }

        $body = $response->getBody()->getContents();

        // Save in cache
        cache()->put("swapi:$url", $body, 3600);

        return json_decode($body, true);
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
