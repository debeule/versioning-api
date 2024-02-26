<?php

declare(strict_types=1);

namespace Http\Controllers\RegionControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Location\Queries\RegionByPostalCode as RegionByPostalCodeQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;

final class RegionByPostalCode extends Controller
{
    public function __construct(
        private RegionByPostalCodeQuery $regionyPostalCodeQuery = new RegionByPostalCodeQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->regionyPostalCodeQuery->find($request->postalCode);
        
        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->regionyPostalCodeQuery->version = $versionObject;
    }
}