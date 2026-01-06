<?php

namespace App\Services\Swapi\Database;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class SwapiDatabaseReset
{
    public function reset(): void
    {

        Schema::disableForeignKeyConstraints();

        $this->truncatePivotTables();
        $this->truncateModels();

        Schema::enableForeignKeyConstraints();

        Log::info('Truncating SWAPI tables', [
            'pivots' => config('swapi.pivot_tables'),
            'models' => config('swapi.models'),
        ]);

    }

    protected function truncatePivotTables(): void
    {
        foreach (config('swapi.pivot_tables', []) as $table) {
            DB::table($table)->truncate();
        }
    }

    protected function truncateModels(): void
    {
        foreach (config('swapi.models', []) as $modelClass) {
            $modelClass::truncate();
        }
    }
}
