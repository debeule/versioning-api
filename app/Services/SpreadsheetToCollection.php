<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Pipeline\Pipeline;

final class SpreadsheetToCollection
{
    public function __construct(
        private string $source,
        private string $objectType,
    ) {}

    public static function setup(string $source, string $objectType): self
    {
        return new self($source, $objectType);
    }
    
    public function pipe(): mixed
    {
        return app(Pipeline::class)
            ->send([
                'source' => $this->source,
                'objectType' => $this->objectType,
            ])
            ->through([
                Pipes\SpreadsheetToArray::class,
                Pipes\SanitizeSpreadsheetArray::class,
                Pipes\ArrayToCollection::class,
            ])
            ->thenReturn();
    }
}