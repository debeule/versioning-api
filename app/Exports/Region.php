<?php

declare(strict_types=1);

namespace App\Exports;

use App\Location\Municipality;
use App\Location\Region as DbRegion;
use Illuminate\Database\Eloquent\Model;

final class Region extends Model
{
    protected $fillable = [
        'region_number',
        'name',
        'linked_municipalities',
    ];

    public static function build(DbRegion $dbRegion): self
    {
        $region = new self();

        $region->addRegionAttributes($dbRegion);
        $region->addLinkedMunicipalitiesAttribute($dbRegion);

        return $region;
    }

    public function addRegionAttributes(DbRegion $dbRegion): void
    {
        $this->region_number = $dbRegion->region_number;
        $this->name = $dbRegion->name;
    }

    public function addLinkedMunicipalitiesAttribute(DbRegion $dbRegion): void
    {
        $municipalities = Municipality::where('region_id', $dbRegion->id)->get();

        $postalCodeArray = [];
        $counter = 0;
        foreach ($municipalities as $municipality) 
        {
            array_push($postalCodeArray, $municipality->postal_code);
        }

        $this->linked_municipalities = $postalCodeArray;
    }
}