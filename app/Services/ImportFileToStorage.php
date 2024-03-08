<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use App\Services\Pipes;

final class ImportFileToStorage
{
    public function __construct(
        private string $source,
        private string $destination,
    ) {}

    public static function setup(string $source, string $destination): self
    {
        return new self($source, $destination);
    }
    
    public function pipe()
    {
        return app(Pipeline::class)
            ->send([
                'source' => $this->source,
                'destination' => $this->destination,
            ])
            ->through([
                Pipes\RetrieveFromSource::class,
                Pipes\StoreFileToDestination::class,
            ])
            ->thenReturn();
    }
}