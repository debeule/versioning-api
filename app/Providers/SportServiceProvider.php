<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalSports;
use App\Bpost\Queries\AllSports;
 
class LocationServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalSports::class, AllSports::class);
    }
}