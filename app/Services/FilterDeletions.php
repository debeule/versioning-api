<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

final class FilterDeletions
{
    public function __construct(
        private Collection $existingRecords,
        private Collection $externalRecords,
    ){}

    public function handle(): Collection
    {
        foreach ($this->externalRecords as $externalRecord) 
        {
            $existingRecords = $this->existingRecords->where('record_id', '!=', $externalRecord->recordId());
        }
        
        return $existingRecords;
    }
}