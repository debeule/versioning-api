<?php

namespace App\Services\ImportFileToStorage;

use Illuminate\Pipeline\Pipeline;
use StdClass;

final class InputObject
{
    public function __construct(
        public string $source,
        public string $destination,
    ) {}

    public static function build(string $source, string $destination): self
    {
        return new self($source, $destination);
    }
}