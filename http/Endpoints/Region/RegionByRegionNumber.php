<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\RegionByRegionNumber as RegionByRegionNumberQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Region;

final class RegionByRegionNumber
{
    public function __construct(
        private RegionByRegionNumberQuery $regionByRegionNumberQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByRegionNumberQuery->hasRegionNumber($request->RegionNumber)->fromVersion($request->version)->find();
        
        if (is_null($region)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Region::build($region));
    }
}