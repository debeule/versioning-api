<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;

final class ProcessImportedRecords
{
    public function __construct(
        private collection $importedRecords,
        private collection $existingRecords,
    ) {}

    public static function setup(Collection $importedRecords, collection $existingRecords): self
    {
        return new self($importedRecords, $existingRecords);
    }
    
    public function pipe(): mixed
    {
        return app(Pipeline::class)
            ->send([
                'records' => $this->importedRecords,
                'existingRecords' => $this->existingRecords,
            ])
            ->through([
                Pipes\FilterNewRecords::class,
                Pipes\FilterUpdatedRecords::class,
                Pipes\FilterDeletedRecords::class,
            ])
            ->thenReturn();
    }
}