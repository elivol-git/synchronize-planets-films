<?php

namespace App\Console\Commands;

use App\Jobs\SynchronizePlanetsJob;
use Illuminate\Console\Command;

class SynchronizePlanets extends Command
{
    protected $signature = 'create:sync-planets';
    protected $description = 'Synchronize planets and their films data';

    public function handle(): int
    {
        dispatch(new SynchronizePlanetsJob());

        $this->info("Planet synchronization job dispatched!");

        return self::SUCCESS;
    }
}
