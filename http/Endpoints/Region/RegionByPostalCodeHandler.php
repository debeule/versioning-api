<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Location\Presentation\Region;
use App\Location\Queries\RegionByPostalCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RegionByPostalCodeHandler
{
    public function __construct(
        private RegionByPostalCode $regionByPostalCode,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByPostalCode->hasPostalCode($request->postalCode)->fromVersion($request->version)->find();
        
        if (is_null($region)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Region::new()->build($region));
    }
}