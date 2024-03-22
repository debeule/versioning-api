<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Collection;

final class ArrayToCollection
{
    /**  
     * @param array<mixed> $content
    */
    public function handle(Array $content, \Closure $next): Collection
    {
        $collection = collect();
        
        foreach ($content['spreadsheetArray'] as $row) 
        {
            $collection->push(new $content['objectType']($row));
        }

        return $next($collection);
    }
}