<?php

declare(strict_types=1);

namespace App\Imports\Values;


final class ProvinceGroup
{
    private array $flemishProvinces = ['antwerpen', 'limburg', 'oost-vlaanderen', 'vlaams-brabant', 'west-vlaanderen'];
    private array $walloonProvinces = ['waals-brabant', 'henegouwen', 'luik', 'luxemburg', 'namen'];
    private array $brussels = ['brussel'];

    public function __construct(
        private array $value = [],
    ) {}

    public function allProvinces(): self
    {
        return new self(array_merge($this->flemishProvinces, $this->walloonProvinces, $this->brussels));
    }

    public function flemishProvinces(): self
    {
        return new self($this->flemishProvinces);
    }

    public function get(): array
    {
        return $this->value;
    }
}