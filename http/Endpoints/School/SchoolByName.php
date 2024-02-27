<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByName as SchoolByNameQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\School;

final class SchoolByName extends Controller
{
    public function __construct(
        private SchoolByNameQuery $schoolByNameQuery = new SchoolByNameQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModel = $this->schoolByNameQuery->find($request->name);

        return response()->json(School::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->schoolByNameQuery->version = $versionObject;
    }
}