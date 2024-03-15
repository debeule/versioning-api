<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Collection;

final class FilterUpdatedRecords
{
    /** @param array<Mixed> $content */
    public function handle(Array $content, \Closure $next): Collection
    {
        $updatedRecords = collect();
         
        foreach ($content['records'] as $record) 
        {
            $existingRecord = $content['existingRecords']
            ->where('record_id', $record->recordId())
            ->first();
            
            if (empty($existingRecord)) continue;
            if(! $existingRecord->hasChanged($record)) continue;

            $updatedRecords->push($record);
        }

        $content['update'] = $updatedRecords;
        
        return $next($content);
    }
}