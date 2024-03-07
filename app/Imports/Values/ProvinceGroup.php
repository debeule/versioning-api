<?php

declare(strict_types=1);

namespace App\Imports\Values;


final class ProvinceGroup
{
    public enum $value;

    public function __construct(
        private enum $flemishProvinces = ['Antwerpen', 'Limburg', 'Oost-Vlaanderen', 'Vlaams-Brabant', 'West-Vlaanderen'],
        private enum $walloonProvinces = ['Brabant Wallon', 'Hainaut', 'Liège', 'Luxembourg', 'Namur'],
        private enum $brussels = ['Brussels'],
    ) {}

    public static function allProvinces()
    {
        return new self($this->flemishProvinces + $this->walloonProvinces + $this->brussels);
    }

    public static function flemishProvinces()
    {
        return new self($this->flemishProvinces);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}