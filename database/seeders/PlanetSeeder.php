<?php

namespace Database\Seeders;

use App\Models\Film;
use App\Models\Planet;

use GuzzleHttp\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PlanetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        Film::truncate();
        Schema::disableForeignKeyConstraints();
        Planet::truncate();
        Schema::enableForeignKeyConstraints();
        $client = new Client();
        $nextPage = 'https://swapi.dev/api/planets/?page=1';

        do {
            $planetsResponse = $client->get($nextPage);
            $planets = $planetsResponse->getBody();
            $planetsData = json_decode($planets, true);
            $numericFields = ['surface_water','population','rotation_period','orbital_period','diameter',];
            foreach ($planetsData['results'] as $planet) {
//            var_dump($planet);
                $planetData = $planet;
                $filmsUrls = $planetData['films'];
                unset($planetData['residents'], $planetData['films']);
                foreach ($numericFields as $field) {
                    if (!is_numeric($planetData[$field])) {
                        unset($planetData[$field]);
                    }
                }
                $createdPlanet = \App\Models\Planet::create($planetData);
                //Fetch related film data and save
                foreach ($filmsUrls as $filmUrl) {
                    $filmResponse = $client->get($filmUrl);
                    $film = $filmResponse->getBody();
                    $filmData = json_decode($film, true);
//                    print_r($filmData);
                    unset($filmData['characters'], $filmData['planets'], $filmData['starships'], $filmData['vehicles'], $filmData['species'] );
                    $filmData['planet_id'] = $createdPlanet->id;
                    \App\Models\Film::create($filmData);
                }

            }
            if(isset($planetsData['next'])) {
                $nextPage = $planetsData['next'];
            } else {
                $nextPage = null;
            }
        } while($nextPage);

    }
}
