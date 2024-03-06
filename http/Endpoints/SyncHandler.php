<?php

namespace Http\Endpoints;

use App\Imports\SyncAllDomains;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Bus\DispatchesJobs;

final class SyncHandler
{
    public function __invoke(): JsonResponse
    {
        try 
        {
            dispatch(new SyncAllDomains);
        } 
        catch (\Throwable $th) 
        {
            return response()->json($th, 500);
        }

        return Response()->json('Syncing', 200);
    }
}