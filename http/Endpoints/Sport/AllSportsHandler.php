<?php

declare(strict_types=1);

namespace Http\Endpoints\Sport;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Sport\Queries\AllSports as AllSportsQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Sport;

final class AllSportsHandler
{
    public function __construct(
        private AllSportsQuery $allSportsQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allSportsQuery->fromVersion($request->version)->find();
        
        if (is_null($responseModels)) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            $response->push(Sport::build($responseModel));
        }

        return response()->json($response);
    }
}