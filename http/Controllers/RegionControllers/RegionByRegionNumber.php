<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Location\Queries\RegionByRegionNumber as RegionByRegionNumberQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\Region;

final class RegionByRegionNumber extends Controller
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

        return $this->jsonifyModels(Region::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->regionByRegionNumberQuery->version = $versionObject;
    }
}