<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Imports\SyncAllDomainsJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\School\Commands\SyncSchoolDomain;
use App\Sport\Commands\SyncSportDomain;
use App\Kohera\School as KoheraSchool;
use App\School\School;

use App\Kohera\Queries\AllSports;
use App\Kohera\Queries\AllSchools;
use App\Kohera\Sport;

final class TestController extends Controller
{
    public function __invoke(): void
    {
        //vertaal Kohera query naar db
        $syncSchool = new SyncSchoolDomain();
        $syncSchool();
        
        $syncSport = new SyncSportDomain();
        $syncSport();
    }
}
