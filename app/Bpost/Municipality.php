<?php

declare(strict_types=1);

namespace App\Bpost;

use App\Imports\Queries\Municipality as MunicipalityContract;
use App\Imports\Sanitizer\Sanitizer;
use App\Location\Region;

final class Municipality implements MunicipalityContract
{
    public function __construct(Array $row) 
    {
        $this->Postcode = $row[0];
        $this->Plaatsnaam = $row[1];
        $this->Deelgemeente = $row[2];
        $this->Hoofdgemeente = $row[3];
        $this->Provincie = $row[4];
    }

    public function name(): string
    {
        return Sanitizer::input($this->Plaatsnaam)->stringToLower()->value();
    }

    public function province(): string
    {
        return Sanitizer::input($this->Provincie)->stringToLower()->value();
    }

    public function postalCode(): int
    {
        return Sanitizer::input($this->Postcode)->intValue();
    }

    public function headMunicipality(): ?string
    {
        if (Sanitizer::input($this->Deelgemeente)->stringToLower()->value() === 'ja')
        {
            return Sanitizer::input($this->Hoofdgemeente)->stringToLower()->value();
        }

        return null;
    }

    public function region(): Region
    {
        return Region::where('region_number', $this->school->RegioDetailId)->first();
    }
}