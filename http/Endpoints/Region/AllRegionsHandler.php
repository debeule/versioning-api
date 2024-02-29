<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\AllRegions;
use Illuminate\Http\JsonResponse;
use App\Exports\Region;

final class AllRegionsHandler
{
    public function __construct(
        private AllRegions $allRegions,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allRegions->fromVersion($request->version)->get();
        
        if (is_null($responseModels)) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            $response->push(Region::build($responseModel));
        }

        return response()->json($response);
    }
}