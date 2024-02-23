<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

trait StringSanitizationTrait
{
    public function stringToLower(): self
    {
        return new self(strtolower($this->input));
    }

    public function trimString(): self
    {
        return new self(trim($this->input));
    }

    public function extractString(): self
    {
        return new self(preg_replace('/[^a-zA-Z]/', '', $this->input));
    }
}