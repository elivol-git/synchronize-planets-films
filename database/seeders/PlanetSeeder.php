<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\SynchronizeStarWarsProcedure;

class PlanetSeeder extends Seeder
{
    public function run(): void
    {
        app(SynchronizeStarWarsProcedure::class)->run();
    }
}
