<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Swapi\Database\SwapiDatabaseReset;

class SwapiResetCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'swapi:reset {--dry : Show what would be truncated without executing}';

    /**
     * The console command description.
     */
    protected $description = 'Reset all SWAPI-related tables (models + pivot tables)';

    public function handle(): int
    {
        $dry = $this->option('dry');

        if ($dry) {
            $this->warn('DRY RUN – no tables will be truncated');
            $this->showDryRun();
            return Command::SUCCESS;
        }

        $this->info('Resetting SWAPI database...');
        (new SwapiDatabaseReset())->reset();
        $this->info('SWAPI database reset completed');

        return Command::SUCCESS;
    }

    protected function showDryRun(): void
    {
        $this->line('Pivot tables:');
        foreach (config('swapi.pivot_tables', []) as $table) {
            $this->line("  - {$table}");
        }

        $this->line('');
        $this->line('Models:');
        foreach (config('swapi.models', []) as $model) {
            $this->line("  - {$model}");
        }
    }
}
