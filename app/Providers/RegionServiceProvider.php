<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Kohera\Queries\AllRegions;
use App\Imports\Queries\ExternalRegions;
 
class RegionServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalRegions::class, AllRegions::class);
    }
}