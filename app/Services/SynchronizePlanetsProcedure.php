<?php

namespace App\Services;

use App\Models\Planet;
use App\Models\Film;
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

            $this->clearTables();
            $this->syncPlanets();

            Log::info("Planet sync completed");
        } catch (\Throwable $e) {
            \Notification::route('mail', 'elivol333@gmail.com')
                ->notify(new SyncFailedNotification($e->getMessage()));

            throw $e;
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

    protected function syncPlanets(): void
    {
        $nextPage = self::INIT_PLANETS_SOURCE;

        while ($nextPage) {

            $response = cache()->remember("swapi:{$nextPage}", 3600, function () use ($nextPage) {
                return $this->client->get($nextPage)->getBody()->getContents();
            });

            $data = json_decode($response, true);

            foreach ($data['results'] as $planet) {
                $this->storePlanetWithFilms($planet);
            }

            $nextPage = $data['next'] ?? null;
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
        $filmDataJson = cache()->remember("swapi:film:$filmUrl", 3600, function () use ($filmUrl) {
            return $this->client->get($filmUrl)->getBody()->getContents();
        });

        $filmData = json_decode($filmDataJson, true);

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
