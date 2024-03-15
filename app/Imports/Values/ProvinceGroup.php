<?php

declare(strict_types=1);

namespace App\Imports\Values;


final class ProvinceGroup
{
    /** @var array<string> $flemishProvinces */
    private static array $flemishProvinces = ['antwerpen', 'limburg', 'oost-vlaanderen', 'vlaams-brabant', 'west-vlaanderen'];
    
    /** @var array<string> $walloonProvinces */
    private static array $walloonProvinces = ['waals-brabant', 'henegouwen', 'luik', 'luxemburg', 'namen'];

    /** @var array<string> $brussels */
    private static array $brussels = ['brussel'];

    /** @param array<string> $value */
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

    /** @return array<string>  */
    public function get(): array
    {
        return $this->value;
    }
}