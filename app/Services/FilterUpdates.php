<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class FilterUpdates
{
    public function __construct(
        private Collection $existingRecords,
        private Collection $externalRecords,
    ){}

    public function handle(): Collection
    {
        $updatedRecords = collect();
         
        foreach ($this->externalRecords as $externalRecord) 
        {
            $existingRecord = $this->existingRecords
            ->where('record_id', $externalRecord->recordId())
            ->first();
            
            if (empty($existingRecord)) continue;
            if(! $existingRecord->hasChanged($externalRecord)) continue;

            $updatedRecords->push($externalRecord);
        }

        return $updatedRecords;
    }
}