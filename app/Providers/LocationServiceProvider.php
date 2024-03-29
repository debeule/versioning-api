<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalMunicipalities;
use App\Bpost\Queries\AllMunicipalities;

use App\Imports\Queries\ExternalRegions;
use App\Kohera\Queries\AllRegions;
 
class LocationServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalMunicipalities::class, AllMunicipalities::class);
        
        $this->app->bind(ExternalRegions::class, AllRegions::class);
    }
}