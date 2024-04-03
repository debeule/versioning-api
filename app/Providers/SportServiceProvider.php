<?php

declare(strict_types=1);

namespace App\Providers;

use App\Imports\Queries\ExternalSports;

use App\Kohera\Queries\AllSports;
use Illuminate\Support\ServiceProvider;
 
class SportServiceProvider extends ServiceProvider 
{
    public function register(): void
    {
        $this->app->bind(ExternalSports::class, AllSports::class);
    }
}