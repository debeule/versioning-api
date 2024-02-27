<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByInstitutionId as SchoolByInstitutionIdQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\School;

final class SchoolByInstitutionId extends Controller
{
    public function __construct(
        private SchoolByInstitutionIdQuery $schoolByInstitutionIdQuery = new SchoolByInstitutionIdQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }
        
        $responseModel = $this->schoolByInstitutionIdQuery->find((int) $request->institutionId);

        return $this->jsonifyModels(School::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->schoolByInstitutionIdQuery->version = $versionObject;
    }
}