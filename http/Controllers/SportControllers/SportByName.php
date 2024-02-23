<?php

declare(strict_types=1);

namespace Http\Controllers\SportControllers;

use Illuminate\Http\Request;
use App\Imports\Objects\Version;
use App\Sport\Queries\SportByName as SportByNameQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Sport\Sport;

final class SportByName extends Controller
{
    public function __construct(
        private SportByNameQuery $sportByNameQuery = new SportByNameQuery()
    ) {}

    public function __invoke(Request $request): JsonResponse
    {
        if (!is_null($request->version))
        {
            $this->setVersion($request->version);
        }

        $responseModels = $this->sportByNameQuery->find($request->value);

        return $this->jsonifyModels($responseModels);
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->sportByNameQuery->version = $versionObject;
    }
}