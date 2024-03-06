<?php

declare(strict_types=1);

namespace App\Imports\Values;

use Carbon\CarbonImmutable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;

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

    public static function fromDateTimeInterface(DateTimeInterface $dateTime): self
    {
        /** @var CarbonImmutable $immutable */
        $immutable = CarbonImmutable::createFromInterface($dateTime);

        return new self($immutable);
    }

    public function __toString(): string
    {
        return  $this->value;
    }
}