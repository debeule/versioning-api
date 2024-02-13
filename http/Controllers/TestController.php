<?php

declare(strict_types=1);

namespace Http\Controllers;

use App\Imports\SyncAllDomainsJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\School\Commands\SyncSchoolDomain;
use App\Sport\Commands\SyncSportDomain;
use App\Kohera\DwhSchool;

final class TestController extends Controller
{
    public function __invoke()
    {
        // dispatch(new SyncAllDomainsJob());
        
        $syncSchool = new SyncSchoolDomain();
        $syncSchool();
        $syncSport = new SyncSportDomain();
        $syncSport();
    }
}
