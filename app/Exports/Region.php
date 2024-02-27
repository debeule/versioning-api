<?php

declare(strict_types=1);

namespace App\Exports;

use Illuminate\Database\Eloquent\Model;
use App\Location\Region as DbRegion;
use App\Location\Municipality;

final class Region extends Model
{
    protected $fillable = [
        'region_number',
        'name',
        'linked_municipalities',
    ];

    public static function build(DbRegion $dbRegion)
    {
        $region = new self();

        $region->addRegionAttributes($dbRegion);
        $region->addLinkedMunicipalitiesAttribute($dbRegion);

        return $region;
    }

    public function addRegionAttributes(DbRegion $dbRegion)
    {
        $this->region_number = $dbRegion->region_number;
        $this->name = $dbRegion->name;
    }

    public function addLinkedMunicipalitiesAttribute(DbRegion $dbRegion)
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