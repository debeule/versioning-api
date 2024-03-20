<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use DateTimeInterface;

final class Version
{
    public string $value;

    public function __construct(
        CarbonImmutable $carbonImmutable = new CarbonImmutable(),
    ) {
        $this->value = $carbonImmutable->toDateString();
    }

    public static function fromString(?string $input): self
    {
        return new self(CarbonImmutable::parse($input ?? ''));
    }

    public function __toString(): string
    {
        return  $this->value;
    }
}