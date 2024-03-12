<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Imports\Values\BpostUri;
use Illuminate\Support\Facades\Http;
use App\Bpost\Municipality;

final class ArrayToCollection
{
    public function handle(mixed $content, \Closure $next)
    {
        $collection = collect();
        
        foreach ($content['spreadsheetArray'] as $row) 
        {
            $collection->push(new $content['objectType']($row));
        }

        return $next($collection);
    }
}