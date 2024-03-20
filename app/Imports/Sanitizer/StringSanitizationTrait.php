<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

trait StringSanitizationTrait
{
    public function stringToLower(): self
    {
        return new self(strtolower($this->value));
    }

    public function trimString(): self
    {
        return new self(trim($this->value));
    }

    public function extractString(): self
    {
        return new self(preg_replace('/[^a-zA-Z]/', '', $this->value));
    }
}