<?php

declare(strict_types=1);

namespace Http\Endpoints\Sport;

use App\Sport\Presentation\Sport as SportExport;
use App\Sport\Queries\AllSports;
use App\Sport\Sport;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class AllSportsHandler
{
    public function __construct(
        private AllSports $allSports,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $responseModels = $this->allSports->fromVersion($request->version)->find();
        
        if ($responseModels->isEmpty()) return response()->json(config('reporting.404'), 404);

        $response = collect();
        foreach ($responseModels as $responseModel) 
        {
            /** @var Sport $responseModel */
            $response->push(SportExport::new()->build($responseModel));
        }

        return response()->json($response);
    }
}