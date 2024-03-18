<?php

declare(strict_types=1);

namespace Http\Endpoints\Sport;

use App\Sport\Presentation\Sport;
use App\Sport\Queries\SportByName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SportByNameHandler
{
    public function __construct(
        private SportByName $sportByName,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $sport = $this->sportByName->hasName($request->name)->fromVersion($request->version)->find();
        
        if (is_null($sport)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Sport::new()->build($sport));
    }
}