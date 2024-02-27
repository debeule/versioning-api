<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\AllSchools as AllSchoolsQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\School;

final class AllSchools extends Controller
{
    public function __construct(
        private AllSchoolsQuery $allSchoolsQuery = new AllSchoolsQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->allSchoolsQuery->get();

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            $response->push(School::build($responseModel));
        }

        return response()->json($response);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->allSchoolsQuery->version = $versionObject;
    }
}