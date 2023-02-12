<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PlanetSeeder;
use Illuminate\Console\Command;

class SynchronizePlanets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:sync-planets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize panets and their films data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DatabaseSeeder $dbSeeder)
    {
	$dbSeeder->call(PlanetSeeder::class);
        return Command::SUCCESS;
    }
}
