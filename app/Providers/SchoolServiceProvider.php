<?php

declare(strict_types=1);

namespace App\Providers;

use App\Imports\Queries\ExternalAddresses;

use App\Imports\Queries\ExternalBillingProfiles;
use App\Imports\Queries\ExternalSchools;

use App\Kohera\Queries\AllAddresses;
use App\Kohera\Queries\AllBillingProfiles;

use App\Kohera\Queries\AllSchools;
use Illuminate\Support\ServiceProvider;

class SchoolServiceProvider extends ServiceProvider 
{
    public function register(): void
    {
        $this->app->bind(ExternalAddresses::class, AllAddresses::class);

        $this->app->bind(ExternalSchools::class, AllSchools::class);
        
        $this->app->bind(ExternalBillingProfiles::class, AllBillingProfiles::class);
    }
}