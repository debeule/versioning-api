<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\RegionByPostalCode as RegionByPostalCodeQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Region;

final class RegionByPostalCodeHandler
{
    public function __construct(
        private RegionByPostalCodeQuery $regionByPostalCodeQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByPostalCodeQuery->hasPostalCode($request->postalCode)->fromVersion($request->version)->find();
        
        if (is_null($region)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Region::build($region));
    }
}