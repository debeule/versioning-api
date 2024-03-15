<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Collection;

final class FilterUpdatedRecords
{
    /** @param array<mixed> $content */
    /** @return array<mixed> */
    public function handle(Array $content, \Closure $next): Array
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