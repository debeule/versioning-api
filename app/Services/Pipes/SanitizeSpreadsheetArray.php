<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Imports\Values\ProvinceGroup;
use Illuminate\Support\Collection;

final class SanitizeSpreadsheetArray
{
    /** @param array<Mixed> $content */
    public function handle(array $content, \Closure $next): Collection
    {
        $resultArray = [];
 
        foreach ($content['spreadsheetArray'] as $row) 
        {
            if (empty($row[4])) continue;
            if (! in_array(strtolower($row[4]), ProvinceGroup::allProvinces()->get())) continue;
    
            array_push($resultArray, $row);
        }

        $content['spreadsheetArray'] = $resultArray;

        return $next($content);
    }
}