<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\RegionByPostalCode as RegionByPostalCodeQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Region;

final class RegionByPostalCode
{
    public function __construct(
        private RegionByPostalCodeQuery $regionByPostalCodeQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByPostalCodeQuery->hasPostalCode($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Region::build($region));
    }
}