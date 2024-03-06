<?php

declare(strict_types=1);

namespace Http\Endpoints;

use App\Imports\SyncAllDomains;
use Illuminate\Http\JsonResponse;

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