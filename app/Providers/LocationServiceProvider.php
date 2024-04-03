<?php

declare(strict_types=1);

namespace App\Providers;

use App\Bpost\Queries\AllMunicipalities;

use App\Imports\Queries\ExternalMunicipalities;
use App\Imports\Queries\ExternalRegions;

use App\Kohera\Queries\AllRegions;
use Illuminate\Support\ServiceProvider;
 
class LocationServiceProvider extends ServiceProvider 
{
    public function register(): void
    {
        $this->app->bind(ExternalMunicipalities::class, AllMunicipalities::class);
        
        $this->app->bind(ExternalRegions::class, AllRegions::class);
    }
}