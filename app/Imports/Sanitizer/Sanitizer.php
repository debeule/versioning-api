<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

final class Sanitizer
{
    private string $input = '';

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public static function input($input): self
    {
        return new self((string) $input);
    }

    public function defaultSanitising(): self
    {
        return new self($this->trimString());
    }

    public function value(): string
    {
        return $this->input;
    }

    public function intValue(): int
    {
        return (int) $this->input;
    }

    //string cleaning methods
    public function stringToLower(): self
    {
        return new self(strtolower($this->input));
    }

    public function trimString(): self
    {
        return new self(trim($this->input));
    }
}