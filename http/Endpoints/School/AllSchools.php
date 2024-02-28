<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\School\Queries\AllSchools as AllSchoolsQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\School;

final class AllSchools
{
    public function __construct(
        private AllSchoolsQuery $allSchoolsQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allSchoolsQuery->fromVersion($request->version)->get();
        
        if (is_null($responseModels)) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            $response->push(School::build($responseModel));
        }

        return response()->json($response);
    }
}