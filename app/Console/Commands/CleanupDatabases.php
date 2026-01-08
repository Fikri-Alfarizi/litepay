<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CleanupDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:cleanup {--seed : Run seeders after cleanup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables from merchant and gateway databases and migrate fresh';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Wiping merchant database...');
        Schema::connection('merchant')->disableForeignKeyConstraints();

        $tables = DB::connection('merchant')->select('SHOW TABLES');
        $colName = 'Tables_in_' . config('database.connections.merchant.database');

        foreach ($tables as $table) {
            if (isset($table->$colName)) {
                Schema::connection('merchant')->dropIfExists($table->$colName);
            }
        }
        Schema::connection('merchant')->enableForeignKeyConstraints();

        $this->info('Wiping gateway database...');
        Schema::connection('gateway')->disableForeignKeyConstraints();
        $tables = DB::connection('gateway')->select('SHOW TABLES');
        $colName = 'Tables_in_' . config('database.connections.gateway.database');

        foreach ($tables as $table) {
            if (isset($table->$colName)) {
                Schema::connection('gateway')->dropIfExists($table->$colName);
            }
        }
        Schema::connection('gateway')->enableForeignKeyConstraints();

        $this->info('Running migrate:fresh...');
        $this->call('migrate:fresh', [
            '--seed' => $this->option('seed'),
        ]);

        $this->info('All databases cleaned and re-migrated!');
    }
}
