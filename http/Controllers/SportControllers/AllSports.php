<?php

declare(strict_types=1);

namespace Http\Controllers\SportControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Sport\Queries\AllSports as AllSportsQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\Sport;

final class AllSports extends Controller
{
    public function __construct(
        private AllSportsQuery $allSportsQuery = new AllSportsQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->allSportsQuery->get();

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            $response->push(Sport::build($responseModel));
        }

        return $this->jsonifyModels($response);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->allSportsQuery->version = $versionObject;
    }
}