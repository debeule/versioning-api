<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Imports\Values\MunicipalitiesUri;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

final class SpreadsheetToArray
{
    public function handle(mixed $content, \Closure $next)
    {
        $content['spreadsheetArray'] = Excel::toArray(new Request(), $content['source'], null, \Maatwebsite\Excel\Excel::XLS)[0];

        return $next($content);
    }
}