<?php

declare(strict_types=1);

namespace Http\Endpoints\Sport;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Sport\Queries\SportByName;
use Illuminate\Http\JsonResponse;
use App\Exports\Sport;

final class SportByNameHandler
{
    public function __construct(
        private SportByName $sportByName,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $sport = $this->sportByName->hasName($request->name)->fromVersion($request->version)->find();
        
        if (is_null($sport)) return response()->json(config('reporting.404'), 404);
        
        return response()->json(Sport::build($sport));
    }
}