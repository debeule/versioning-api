<?php

declare(strict_types=1);

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use App\Sport\Queries\AllSports as AllSportsQuery;
use Illuminate\Http\JsonResponse;

final class AllSports extends Controller
{
    public function __construct(
        private AllSportsQuery $allSportsQuery
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }
        $responseModels = $this->allSportsQuery->get();
        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $this->allSportsQuery->version = $version;
    }
}