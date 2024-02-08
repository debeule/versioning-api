<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Jobs\SyncAllDomainsJob;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Redis;

class TestController extends Controller
{
    public function __invoke()
    {
        dispatch(new SyncAllDomainsJob());
    }
}
