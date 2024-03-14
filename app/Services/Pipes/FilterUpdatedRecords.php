<?php

declare(strict_types=1);

namespace App\Services\Pipes;


final class FilterUpdatedRecords
{
    public function handle(mixed $content, \Closure $next)
    {
        $collection = collect();
        $existingRecords = $content['objectType']::all();
        
        foreach ($content['records'] as $record) 
        {
            $sportExists = $existingSports->where('record_id', $koheraSport->recordId())->isNotEmpty();

            if ($sportExists) $collection->push($record);
        }

        return $next($collection);
    }

    #TODO: mixed ok?
    public function isUpdated(Mixed $record, Mixed $existingRecord)
    {
        $isUpdated = false;

        foreach ($record->getFillables() as $value) 
        {
            //check fields updated
        }

        return $isUpdated;
    }
}