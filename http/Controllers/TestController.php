<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SyncSchoolsDomainJob;
use App\Jobs\SyncSportsDomainJob;
use Illuminate\Foundation\Bus\DispatchesJobs;

class TestController extends Controller
{
    public function __invoke()
    {
        dispatch(new SyncSportsDomainJob());
        dispatch(new SyncSchoolsDomainJob());
    }
}
