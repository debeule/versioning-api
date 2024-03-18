<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use App\School\Presentation\School;
use App\School\Queries\SchoolByName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SchoolByNameHandler
{
    public function __construct(
        private SchoolByName $schoolByName,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $school = $this->schoolByName->hasName($request->name)->fromVersion($request->version)->find();
        
        if (is_null($school)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(School::new()->build($school));
    }
}