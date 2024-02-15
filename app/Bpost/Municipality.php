<?php

declare(strict_types=1);

namespace App\Bpost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\Municipality as MunicipalityContract;
use App\School\Region;

final class Municipality extends Model implements MunicipalityContract
{
    protected $fillable = [
        'name',
        'postal_code',
        'head_municipality',
        'province',
    ];

    public function name(): string
    {
        return $this->name;
    }

    public function province(): string
    {
        return $this->province;
    }

    public function postalCode(): int
    {
        return (int) $this->postal_code;
    }

    public function headMunicipality(): ?string
    {
        return $this->head_municipality;
    }

    public function region(): Region
    {
        return Region::where('name', $this->school->RegioDetailId)->first();
    }
}