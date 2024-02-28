<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class Version
{
    public function __construct(
        public string $value = '',
        CarbonImmutable $carbonImmutable = new CarbonImmutable(),
    ) {
        $value = $carbonImmutable->toDateString(CarbonImmutable::now());
    }

    public function fromString(string $input): self
    {
        new self(CarbonImmutable::parse($input));
    }

    public static function fromDateTimeInterface(DateTimeInterface $dateTime): self
    {
        $immutable = CarbonImmutable::createFromInterface($dateTime);

        return new self($immutable);
    }

    public function __toString(): string
    {
        return  $this->value;
    }
}