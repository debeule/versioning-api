<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterNewRecords
{
    /** @param array<mixed> $content */
    /** @return array<mixed> */
    public function handle(Array $content, \Closure $next): Array
    {
        $newRecords = collect();
         
        foreach ($content['records'] as $record) 
        {
            $recordExists = $content['existingRecords']
            ->where('record_id', $record->recordId())
            ->isNotEmpty();

            if (! $recordExists) $newRecords->push($record);
        }

        $content['create'] = $newRecords;
        
        return $next($content);
    }
}