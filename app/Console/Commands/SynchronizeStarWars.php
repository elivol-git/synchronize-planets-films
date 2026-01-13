<?php

namespace App\Console\Commands;

use App\Jobs\SynchronizePlanetsJob;
use App\Services\SynchronizeStarWarsProcedure;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as CommandAlias;

class SynchronizeStarWars extends Command
{
    protected $signature = 'swapi:sync
                            {--fresh : Reset SWAPI tables before syncing}
                            {--queue : Dispatch sync jobs instead of running inline}';

    protected $description = 'Synchronize Star Wars data from SWAPI';

    public function handle(SynchronizeStarWarsProcedure $procedure): int
    {
        if ($this->option('fresh')) {
            $this->call('swapi:reset');
        }

        if ($this->option('queue')) {
            dispatch(new SynchronizePlanetsJob());
            $this->info('SWAPI sync jobs dispatched');
        } else {
            $procedure->run();
            $this->info('SWAPI synchronization completed');
        }

        return CommandAlias::SUCCESS;
    }
}
