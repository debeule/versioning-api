<?php

namespace App\Services\ImportFileToStorage;

use Illuminate\Pipeline\Pipeline;
use App\Services\ImportFileToStorage\Pipes;

final class ImportFileToStorage
{
    public function __construct(
        private string $source,
        private string $destination,
    ) {}
    
    public function pipe()
    {
        return app(Pipeline::class)
            ->send(InputObject::build($this->source, $this->destination))
            ->through([
                Pipes\RetrieveFileFromSource::class,
                Pipes\StoreFileToDestination::class,
            ])
            ->thenReturn();
    }
}