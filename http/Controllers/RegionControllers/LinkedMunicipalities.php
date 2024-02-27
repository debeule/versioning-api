<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Location\Queries\AllLinkedMunicipalities as AllLinkedMunicipalitiesQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;

final class LinkedMunicipalities extends Controller
{
    public function __construct(
        private AllLinkedMunicipalitiesQuery $allRegionMunicipalitiesQuery = new AllLinkedMunicipalitiesQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->allRegionMunicipalitiesQuery->get((int) $request->regionNumber);

        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->allRegionMunicipalitiesQuery->version = $versionObject;
    }
}