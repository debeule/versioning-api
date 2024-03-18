<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Location\Presentation\Region;
use App\Location\Queries\RegionByRegionNumber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


final class RegionByRegionNumberHandler
{
    public function __construct(
        private RegionByRegionNumber $regionByRegionNumber,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByRegionNumber->hasRegionNumber($request->regionNumber)->fromVersion($request->version)->find();
        
        if (is_null($region)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Region::build($region));
    }
}