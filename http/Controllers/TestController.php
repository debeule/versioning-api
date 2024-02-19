<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Imports\SyncAllDomainsJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\School\Commands\SyncSchoolDomain;
use App\Sport\Commands\SyncSportDomain;
use App\Location\Commands\SyncLocationDomain;

use App\Kohera\School as KoheraSchool;
use App\School\School;

use App\Kohera\Queries\AllSports;
use App\Kohera\Queries\AllSchools;
use App\Kohera\Sport;

final class TestController extends Controller
{
    public function __invoke(): void
    {
        $syncLocation = new SyncLocatio nDomain();
        $syncLocation();

        $syncSchool = new SyncSchoolDomain();
        $syncSchool();
        
        $syncSport = new SyncSportDomain();
        $syncSport();
    }
}
