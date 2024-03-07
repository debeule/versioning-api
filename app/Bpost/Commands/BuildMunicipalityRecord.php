<?php

namespace App\Bpost\Commands;

use App\Bpost\Municipality;

final class BuildMunicipalityRecord
{
    public function __construct(
        private Municipality $municipality = new Municipality,
    ) {}

    public static function build(array $fieldsArray)
    {
        return new self(
            new Municipality(
                Plaatsnaam: $fieldsArray[1],
                Postcode: $fieldsArray[0],
                Provincie: strtolower($fieldsArray[4]),
                Hoofdgemeente: $fieldsArray[2] === 'Ja' ? $fieldsArray[3] : null,
            )
        );
    }

    public function get()
    {
        return $this->municipality;
    }
}