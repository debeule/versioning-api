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
        $region = $this->regionByRegionNumberQuery->hasRegionNumber($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Region::build($region));
    }
}