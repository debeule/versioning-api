<?php

namespace App\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase as BaseRefreshDatabase;
use App\Testing\CanConfigureMigrationCommands;
use App\Testing\RefreshDatabaseState;

trait RefreshDatabase
{
    use BaseRefreshDatabase, CanConfigureMigrationCommands;

    protected function refreshTestDatabase()
    {
        if (! RefreshDatabaseState::$migrated) {
            $this->artisan('migrate:fresh', $this->customMigrateFreshUsing());

            $this->app[Kernel::class]->setArtisan(null);

            RefreshDatabaseState::$migrated = true;
        }

        $this->beginDatabaseTransaction();
    }
}