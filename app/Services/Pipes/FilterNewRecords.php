<?php

declare(strict_types=1);

namespace App\Services\Pipes;

use App\Extensions\Eloquent\Scopes\HasRecordId;

final class FilterNewRecords
{
    public function handle(mixed $content, \Closure $next)
    {
        $newRecords = collect();
         
        foreach ($content['records'] as $record) 
        {
            #TODO: make into scope (with seperate method for 'scoping' collections?)
            $recordExists = $content['existingRecords']
            ->where('record_id', $record->recordId())
            ->isNotEmpty();

            if (!$recordExists) $newRecords->push($record);
        }

        $content['create'] = $newRecords;
        
        return $next($content);
    }
}