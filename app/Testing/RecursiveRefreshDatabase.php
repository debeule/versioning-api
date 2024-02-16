<?php
namespace App\Testing;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait RecursiveRefreshDatabase 
{
    use RefreshDatabase;

    protected function refreshDatabase()
    {
        // $this->artisan('migrate', ['--path' => 'database/kohera/migrations/']);
        // $this->artisan('migrate', ['--path' => 'database/main/migrations/', '--database' => 'db-testing']);
    }
}