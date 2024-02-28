<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByInstitutionId as SchoolByInstitutionIdQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\School;

final class SchoolByInstitutionId
{
    public function __construct(
        private SchoolByInstitutionIdQuery $schoolByInstitutionIdQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $sport = $this->schoolByInstitutionIdQuery->hasInstitutionId($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Sport::build($sport));
    }
}