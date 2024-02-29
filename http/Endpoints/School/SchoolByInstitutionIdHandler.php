<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByInstitutionId;
use Illuminate\Http\JsonResponse;
use App\Exports\School;

final class SchoolByInstitutionIdHandler
{
    public function __construct(
        private SchoolByInstitutionId $schoolByInstitutionId,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $school = $this->schoolByInstitutionId->hasInstitutionId($request->institutionId)->fromVersion($request->version)->find();
        
        if (is_null($school)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(School::build($school));
    }
}