<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Extensions\Eloquent\Scopes\HasRecordId;

final class FilterDeletedRecords
{
    public function handle(mixed $content, \Closure $next)
    {
        $collection = collect();
         
        foreach ($content['records'] as $record) 
        {
            $hasRecordId = new HasRecordId($record->record_id);

            $recordDeleted = $content['existingRecords']->$hasRecordId->isNotEmpty();

            if ($recordDeleted) $collection->push($collection);
        }

        dd($collection);
        
        $content['deleted'] = $collection;
        
        return $next($collection);
    }
}