<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\School\Queries\SchoolByInstitutionId as SchoolByInstitutionIdQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\School\School;

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
        
        $responseModels = $this->schoolByInstitutionIdQuery->find((int) $request->institutionId);
        
        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->schoolByInstitutionIdQuery->version = $versionObject;
    }
}