<?php

declare(strict_types=1);

namespace Http\Endpoints\Region;

use App\Exports\Region;
use App\Location\Queries\RegionByName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class RegionByNameHandler
{
    public function __construct(
        private RegionByName $regionByName,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $region = $this->regionByName->hasName($request->name)->fromVersion($request->version)->find();
        
        if (is_null($region)) return response()->json(config('reporting.404'), 404);

        return response()->json(Region::build($region));
    }
}