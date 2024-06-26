<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Location\Presentation\Region as RegionExport;
use App\Location\Queries\AllRegions;
use App\Location\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AllRegionsHandler
{
    public function __construct(
        private AllRegions $allRegions,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allRegions->fromVersion($request->version)->get();
        
        if ($responseModels->isEmpty()) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            /** @var Region $responseModel */
            $response->push(RegionExport::new()->build($responseModel));
        }

        return response()->json($response);
    }
}