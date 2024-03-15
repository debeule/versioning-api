<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use Illuminate\Support\Collection;

final class FilterDeletedRecords
{
    /** @param array<Mixed> $content */
    public function handle(Array $content, \Closure $next): Collection
    {
        $deletedRecords = $content['existingRecords'];
         
        //delete existing records
        foreach ($content['records'] as $record) 
        {
            $deletedRecords = $deletedRecords->where('record_id', '!=', $record->recordId());
        }
        
        $content['delete'] = $deletedRecords;
        
        return $next($content);
    }
}