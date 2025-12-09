<?php

namespace App\Jobs;

use App\Services\SynchronizePlanetsProcedure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SynchronizePlanetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;             // Retry 5 times
    public int $backoff = 15;          // Wait 15 sec between retries
    public int $timeout = 120;         // Max 2 minutes

    public function handle(SynchronizePlanetsProcedure $sync)
    {
        Log::info("Running SynchronizePlanetsJob...");
        $sync->run();
    }

    public function failed(\Throwable $e)
    {
        Log::error("Planet sync failed: " . $e->getMessage());
    }
}
