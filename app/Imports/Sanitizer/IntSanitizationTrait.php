<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

trait IntSanitizationTrait
{
    public function extractInt(): self
    {
        return new self(preg_replace('/[^0-9]/', '', $this->input));
    }
}