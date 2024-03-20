<?php

declare(strict_types=1);

namespace App\Imports\Sanitizer;

final class Sanitizer
{
    use StringSanitizationTrait, IntSanitizationTrait;

    public function __construct(
        private string $value
    ) {}

    public static function input(mixed $input): self
    {
        return (new self((string) $input))->defaultSanitising();
    }

    public function defaultSanitising(): self
    {
        return new self($this->trimString()->value());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function numericValue(): int
    {
        return (int) $this->value;
    }
}