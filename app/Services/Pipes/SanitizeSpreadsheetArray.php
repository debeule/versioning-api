<?php

namespace App\Services\Pipes;

use Illuminate\Support\Collection;
use App\Imports\Values\ProvinceGroup;

final class SanitizeSpreadsheetArray
{
    public function handle(array $content, \Closure $next)
    {
        $resultArray = [];

        foreach ($content as $row) 
        {
            if ($row[4] == null)  continue;
    
            if (! in_array(strtolower($row[4]), ProvinceGroup::allProvinces()->get())) continue;
    
            array_push($resultArray, $row);
        }

        return $next($resultArray);
    }
}