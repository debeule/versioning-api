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
        $deletedRecords = $this->existingRecords;

        foreach ($this->externalRecords as $externalRecord) 
        {
            $deletedRecords = $deletedRecords->where('record_id', '!=', $externalRecord->recordId());
        }
        
        return $deletedRecords;
    }
}