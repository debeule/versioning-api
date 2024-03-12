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
        $municipalities = collect();
        
        foreach ($content as $row) 
        {
            $municipalities->push(new Municipality($row));
        }
        return $next($municipalities);
    }
}