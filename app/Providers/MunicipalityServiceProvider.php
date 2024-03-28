<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Bpost\Queries\AllMunicipalities;
use App\Imports\Queries\ExternalMunicipalities;
 
class MunicipalityServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalMunicipalities::class, AllMunicipalities::class);
    }
}