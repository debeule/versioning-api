<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Location\Queries\RegionByName as RegionByNameQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\Region;

final class RegionByName extends Controller
{
    public function __construct(
        private RegionByNameQuery $regionByNameQuery = new RegionByNameQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModel = $this->regionByNameQuery->find($request->name);

        return $this->jsonifyModels(Region::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->regionByNameQuery->version = $versionObject;
    }
}