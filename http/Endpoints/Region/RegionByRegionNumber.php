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
        private RegionByRegionNumberQuery $regionByRegionNumberQuery = new RegionByRegionNumberQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModel = $this->regionByRegionNumberQuery->find((int) $request->regionNumber);

        return response()->json(Region::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->regionByRegionNumberQuery->version = $versionObject;
    }
}