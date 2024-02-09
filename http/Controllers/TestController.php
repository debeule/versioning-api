<?php

namespace Http\Controllers;

use App\Jobs\SyncAllDomainsJob;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

use App\Schools\Commands\SyncSchoolsDomainCommand;
use App\Sports\Commands\SyncSportsDomainCommand;
use App\Kohera\DwhSchool;

class TestController extends Controller
{
    public function __invoke()
    {
        dispatch(new SyncAllDomainsJob());
        
        // $syncSchools = new SyncSchoolsDomainCommand();
        // $syncSchools();

        // $syncSports = new SyncSportsDomainCommand();
        // $syncSports();
    }
}
