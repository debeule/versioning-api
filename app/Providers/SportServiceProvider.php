<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalSports;
use App\Sport\Queries\AllSports;
 
class SportServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalSports::class, AllSports::class);
    }
}