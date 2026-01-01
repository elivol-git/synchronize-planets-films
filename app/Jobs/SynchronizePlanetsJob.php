<?php

namespace App\Jobs;

use App\Notifications\SyncFailedNotification;
use App\Services\SynchronizePlanetsProcedure;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SynchronizePlanetsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 5;             // Retry 5 times
    public int $backoff = 15;          // Wait 15 sec between retries
    public int $timeout = 120;         // Max 2 minutes

    public function handle(SynchronizePlanetsProcedure $sync): void
    {
        Log::info("Running SynchronizePlanetsJob...");
        $sync->run();
    }

    public function failed(\Throwable $e): void
    {
        Log::error(__CLASS__.": Planet sync permanently failed", [
            'error' => $e->getMessage(),
        ]);

        Notification::route('mail', config('mail.from.address'))
            ->notify(new SyncFailedNotification($e->getMessage()));
    }
}
