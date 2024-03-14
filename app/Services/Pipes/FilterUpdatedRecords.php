<?php

declare(strict_types=1);

namespace App\Services\Pipes;

final class FilterUpdatedRecords
{
    public function handle(mixed $content, \Closure $next)
    {
        $updatedRecords = collect();
         
        foreach ($content['records'] as $record) 
        {
            $existingRecord = $content['existingRecords']
            ->where('record_id', $record->recordId())
            ->first();
            
            if (empty($existingRecord)) continue;
            if(!$existingRecord->hasChanged($record)) continue;

            $updatedRecords->push($existingRecord);
        }

        $content['update'] = $updatedRecords;
        
        return $next($content);
    }
}