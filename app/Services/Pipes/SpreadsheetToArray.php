<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

final class SpreadsheetToArray
{
    /** @param array<Mixed> $content */
    public function handle(Array $content, \Closure $next): Mixed
    {
        $content['spreadsheetArray'] = Excel::toArray(new Request(), $content['source'], null, \Maatwebsite\Excel\Excel::XLS)[0];

        return $next($content);
    }
}