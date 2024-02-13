<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Imports\SyncAllDomainsJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Schools\Commands\SyncSchoolsDomain;
use App\Sports\Commands\SyncSportsDomain;
use App\Kohera\DwhSchool;

final class TestController extends Controller
{
    public function __invoke()
    {
        // dispatch(new SyncAllDomainsJob());
        
        $syncSchools = new SyncSchoolsDomain();
        $syncSchools();

        $syncSports = new SyncSportsDomain();
        $syncSports();
    }
}
