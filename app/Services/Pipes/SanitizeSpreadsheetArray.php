<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Imports\Values\ProvinceGroup;

final class SanitizeSpreadsheetArray
{
    public function handle(array $content, \Closure $next)
    {
        $resultArray = [];

        foreach ($content['spreadsheetArray'] as $row) 
        {
            if (! in_array(strtolower($row[4]), ProvinceGroup::allProvinces()->get())) continue;
    
            array_push($resultArray, $row);
        }

        $content['spreadsheetArray'] = $resultArray;

        return $next($content);
    }
}