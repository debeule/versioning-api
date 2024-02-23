<?php

declare(strict_types=1);

namespace Http\Controllers\SchoolControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Objects\Version;
use DateTimeImmutable;
use App\Sport\Queries\AllSports as AllSportsQuery;
use Illuminate\Http\JsonResponse;
use Http\Controllers\Controller;

final class AllSchools extends Controller
{
    public function __invoke()
    {
        
    }
}