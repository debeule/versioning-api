<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterDeletedRecords
{
    /** @param array<mixed> $content */
    /** @return array<mixed> */
    public function handle(Array $content, \Closure $next): Array
    {
        $recordsToDelete = $content['existingRecords'];
         
        //delete existing records
        foreach ($content['records'] as $record) 
        {
            $recordsToDelete = $recordsToDelete->where('record_id', '!=', $record->recordId());
        }
        
        $content['delete'] = $recordsToDelete;
        
        return $next($content);
    }
}