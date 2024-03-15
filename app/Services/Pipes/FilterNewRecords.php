<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Collection;

final class FilterNewRecords
{
    /** @param array<Mixed> $content */
    public function handle(Array $content, \Closure $next): Collection
    {
        $newRecords = collect();
         
        foreach ($content['records'] as $record) 
        {
            #TODO: make into scope (with seperate method for 'scoping' collections?)
            $recordExists = $content['existingRecords']
            ->where('record_id', $record->recordId())
            ->isNotEmpty();

            if (! $recordExists) $newRecords->push($record);
        }

        $content['create'] = $newRecords;
        
        return $next($content);
    }
}