<?php

declare(strict_types=1);

namespace App\Bpost;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Municipality as MunicipalityContract;
use App\Location\Region;

final class Municipality extends Model implements MunicipalityContract
{
    protected $fillable = [
        'Plaatsnaam',
        'Postcode',
        'Deelgemeente',
        'HoofdGemeente',
        'Provincie',
    ];

    public function name(): string
    {
        return $this->Plaatsnaam;
    }

    public function province(): string
    {
        return $this->Provincie;
    }

    public function postalCode(): int
    {
        return $this->Postcode;
    }

    public function headMunicipality(): ?string
    {
        return $this->Hoofdgemeente;
    }

    public function region(): Region
    {
        return Region::where('region_number', $this->school->RegioDetailId)->first();
    }
}