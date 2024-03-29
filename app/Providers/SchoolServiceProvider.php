<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Imports\Queries\ExternalAddresses;
use App\Kohera\Queries\AllAddresses;

use App\Imports\Queries\ExternalSchools;
use App\Kohera\Queries\AllSchools;

use App\Imports\Queries\ExternalBillingProfiles;
use App\Kohera\Queries\AllBillingProfiles;

class SchoolServiceProvider extends ServiceProvider 
{
    public function register()
    {
        $this->app->bind(ExternalAddresses::class, AllAddresses::class);

        $this->app->bind(ExternalSchools::class, AllSchools::class);
        
        $this->app->bind(ExternalBillingProfiles::class, AllBillingProfiles::class);
    }
}