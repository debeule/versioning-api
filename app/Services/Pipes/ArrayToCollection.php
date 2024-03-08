<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Imports\Values\BpostUri;
use Illuminate\Support\Facades\Http;
use App\Bpost\Commands\BuildMunicipalityRecord;

final class ArrayToCollection
{
    public function handle(mixed $content, \Closure $next)
    {
        $municipalities = collect();
        
        foreach ($content as $row) 
        {
            $municipalities->push(BuildMunicipalityRecord::build($row)->get());
        }

        return $next($municipalities);
    }
}