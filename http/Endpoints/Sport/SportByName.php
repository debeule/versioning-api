<?php

declare(strict_types=1);

namespace Http\Endpoints\Sport;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Sport\Queries\SportByName as SportByNameQuery;
use Illuminate\Http\JsonResponse;
use App\Exports\Sport;

final class SportByName
{
    public function __construct(
        private SportByNameQuery $sportByNameQuery,
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        $sport = $this->sportByNameQuery->hasName($request->name)->fromVersion($request->version)->find();
        
        return response()->json(Sport::build($sport));
    }
}