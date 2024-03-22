<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterNewRecords
{
    /** 
     * @return array<mixed> 
     * @param array<mixed> $content
    */
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