<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Extensions\Eloquent\Scopes\HasRecordId;
use App\Sport\Sport;

final class FilterDeletedRecords
{
    public function handle(mixed $content, \Closure $next)
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