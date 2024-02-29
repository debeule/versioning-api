<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByName as SchoolByNameQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\School;

final class SchoolByNameHandler
{
    public function __construct(
        private SchoolByNameQuery $schoolByNameQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $school = $this->schoolByNameQuery->hasName($request->name)->fromVersion($request->version)->find();
        
        if (is_null($school)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(School::build($school));
    }
}