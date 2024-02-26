<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Location\Queries\AllRegions as AllRegionsQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;

final class AllRegions extends Controller
{
    public function __construct(
        private AllRegionsQuery $allRegionsQuery = new AllRegionsQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->allRegionsQuery->get();

        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->allRegionsQuery->version = $versionObject;
    }
}