<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

final class Sanitizer
{
    use StringSanitizationTrait, IntSanitizationTrait;

    public function __construct(
        private string $input = 'a'
    ) {}

    public static function input(mixed $input): self
    {
        return new self((string) $input);
    }

    public function defaultSanitising(): self
    {
        return new self($this->trimString()->value());
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