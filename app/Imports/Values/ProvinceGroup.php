<?php

declare(strict_types=1);

namespace App\Imports\Values;


final class ProvinceGroup
{
    private static array $flemishProvinces = ['antwerpen', 'limburg', 'oost-vlaanderen', 'vlaams-brabant', 'west-vlaanderen'];
    private static array $walloonProvinces = ['waals-brabant', 'henegouwen', 'luik', 'luxemburg', 'namen'];
    private static array $brussels = ['brussel'];

    public function __construct(
        private array $value = [],
    ) {}

    public static function allProvinces(): self
    {
        return new self(array_merge(self::$flemishProvinces, self::$walloonProvinces, self::$brussels));
    }

    public static function flemishProvinces(): self
    {
        return new self(self::$flemishProvinces);
    }

    public function get(): array
    {
        return $this->value;
    }
}