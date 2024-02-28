<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\SchoolByName as SchoolByNameQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\School;

final class SchoolByName
{
    public function __construct(
        private SchoolByNameQuery $schoolByNameQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $sport = $this->schoolByNameQuery->hasName($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Sport::build($sport));
    }
}