<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class Version
{
    public CarbonImmutable $value;
    
    public function __construct(
        CarbonImmutable $carbonImmutable,
    ) {
        $this->value = CarbonImmutable::toDateString(); 
    }

    public function fromString(string $value): self
    {
        new self(CarbonImmutable::parse($value));
    }

    public static function fromDateTimeInterface(DateTimeInterface $dateTime): self
    {
        $immutable = CarbonImmutable::createFromInterface($dateTime);

        return new self($immutable);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}