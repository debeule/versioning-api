<?php

namespace App\Services;

use Illuminate\Pipeline\Pipeline;
use App\Services\Pipes;

final class SpreadsheetToCollection
{
    public function __construct(
        private string $source,
    ) {}

    public static function setup(string $source): self
    {
        return new self($source);
    }
    
    public function pipe()
    {
        return app(Pipeline::class)
            ->send([
                'source' => $this->source,
            ])
            ->through([
                Pipes\SpreadsheetToArray::class,
                Pipes\SanitizeSpreadsheetArray::class,
                Pipes\ArrayToCollection::class,
            ])
            ->thenReturn();
    }
}