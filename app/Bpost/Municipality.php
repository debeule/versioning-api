<?php

declare(strict_types=1);

namespace App\Bpost;

use App\Imports\Queries\Municipality as MunicipalityContract;
use App\Imports\Sanitizer\Sanitizer;
use App\Location\Municipality as DbMunicipality;

final class Municipality implements MunicipalityContract
{
    public int $Postcode;
    public string $Plaatsnaam;
    public string $Deelgemeente;
    public string $Hoofdgemeente;
    public string $Provincie;

    /** @param array<int,string> $row   */
    public function __construct(Array $row) 
    {
        $this->Postcode = (int) $row[0];
        $this->Plaatsnaam = $row[1];
        $this->Deelgemeente = $row[2];
        $this->Hoofdgemeente = $row[3];
        $this->Provincie = $row[4];
    }

    public function recordId(): string
    {
        return Sanitizer::input($this->Postcode . '-' . $this->Plaatsnaam)->value();
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
        return Sanitizer::input($this->Postcode)->numericValue();
    }

    public function headMunicipality(): ?string
    {
        if (Sanitizer::input($this->Deelgemeente)->stringToLower()->value() === 'ja')
        {
            return Sanitizer::input($this->Hoofdgemeente)->stringToLower()->value();
        }

        return null;
    }

    public function hasChanged(DbMunicipality $dbMunicipality): bool
    {
        $recordHasChanged = false;
        
        $recordHasChanged = $dbMunicipality->name !== $this->name();
        $recordHasChanged = $recordHasChanged || $dbMunicipality->province !== $this->province();

        if (! is_null($this->headMunicipality())) 
        {
            $recordHasChanged = $recordHasChanged || $dbMunicipality->head_municipality !== $this->headMunicipality();
        }
        
        return $recordHasChanged;
    }
}