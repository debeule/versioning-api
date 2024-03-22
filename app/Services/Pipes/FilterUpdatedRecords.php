<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterUpdatedRecords
{
    /** 
     * @return array<mixed> 
     * @param array<mixed> $content
    */
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