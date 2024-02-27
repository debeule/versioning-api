<?php

declare(strict_types=1);

namespace Http\Controllers\SportControllers;

use Illuminate\Http\Request;
use App\Imports\Values\Version;
use App\Sport\Queries\SportByName as SportByNameQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;
use App\Exports\Sport;

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

        $responseModel = $this->sportByNameQuery->find($request->name);

        return $this->jsonifyModels(Sport::build($responseModel));
    }

    public function setVersion(string $version): void
    {
        $versionObject = new Version();
        $versionObject($version);

        $this->sportByNameQuery->version = $versionObject;
    }
}