<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

final class Sanitizer
{
    use StringSanitizationTrait, IntSanitizationTrait;

    public function __construct(
        private string $input = 'a'
    ) {}

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
}