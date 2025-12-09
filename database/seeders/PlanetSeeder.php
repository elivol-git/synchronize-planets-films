<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\SynchronizePlanetsProcedure;

class PlanetSeeder extends Seeder
{
    public function run(): void
    {
        app(SynchronizePlanetsProcedure::class)->run();
    }
}
