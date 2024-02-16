<?php

declare(strict_types=1);

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Objects\Version;
use DateTimeImmutable;

final class RetrieveDataController extends Controller
{
    protected Version $version;

    public function __invoke(Request $request): void
    {
        
    }
}