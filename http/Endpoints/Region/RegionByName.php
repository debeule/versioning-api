<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\RegionByName as RegionByNameQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Region;

final class RegionByName
{
    public function __construct(
        private RegionByNameQuery $regionByNameQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByNameQuery->hasName($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Region::build($region));
    }
}