<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\School\Queries\SchoolByNameQuery as SchoolByNameQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\School\School;

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

        $responseModels = $this->schoolByNameQuery->find($request->value);

        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->schoolByNameQuery->version = $versionObject;
    }
}