<?php

declare(strict_types=1);

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use App\Sport\Queries\AllSports as AllSportsQuery;
use Illuminate\Http\JsonResponse;

final class AllSportsTest extends Controller
{
    #[Test]
    itReturnsAllSportsJson(): void
    {
        
    }

    #[Test]
    itReturnsCorrectVersionRecords(): void
    {
        
    }


}