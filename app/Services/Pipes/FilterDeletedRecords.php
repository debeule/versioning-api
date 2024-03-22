<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterDeletedRecords
{
    /** 
     * @return array<mixed> 
     * @param array<mixed> $content
    */
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