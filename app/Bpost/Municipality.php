<?php

declare(strict_types=1);

namespace App\Bpost;

use Illuminate\Database\Eloquent\Model;
use App\Imports\Queries\Municipality as MunicipalityContract;
use App\Location\Region;
use App\Imports\Sanitizer\Sanitizer;

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
        return Sanitizer::input($this->Hoofdgemeente)->stringToLower()->value();
    }

    public function region(): Region
    {
        return Region::where('region_number', $this->school->RegioDetailId)->first();
    }
}