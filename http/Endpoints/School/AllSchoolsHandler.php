<?php

declare(strict_types=1);

namespace Http\Endpoints\School;

use App\School\Presentation\School as SchoolExport;
use App\School\Queries\AllSchools;
use App\School\School;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AllSchoolsHandler
{
    public function __construct(
        private AllSchools $allSchools,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allSchools->fromVersion($request->version)->get();
        
        if ($responseModels->isEmpty()) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            /** @var School $responseModel */
            $response->push(SchoolExport::new()->build($responseModel));
        }

        return response()->json($response);
    }
}