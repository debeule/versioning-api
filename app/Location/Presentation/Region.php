<?php

declare(strict_types=1);

namespace App\Location\Presentation;

use App\Location\Municipality;
use App\Location\Region as DbRegion;
use Illuminate\Database\Eloquent\Model;

final class Region
{
    public string $name;
    public int $region_number;

    /** @var array<int> $linked_municipalities */
    public array $linked_municipalities;

    public static function new(): self
    {
        return new self();
    }

    public function build(DbRegion $dbRegion): self
    {
        $this->addRegionAttributes($dbRegion);
        $this->addLinkedMunicipalitiesAttribute($dbRegion);

            return $this;
    }

    public function addRegionAttributes(DbRegion $dbRegion): void
    {
        $this->name = $dbRegion->name;
        $this->region_number = $dbRegion->region_number;
    }

    public function addLinkedMunicipalitiesAttribute(DbRegion $dbRegion): void
    {
        $municipalities = Municipality::where('region_id', $dbRegion->id)->get();

        $postalCodeArray = [];
        
        foreach ($municipalities as $municipality) 
        {
            array_push($postalCodeArray, $municipality->postal_code);
        }

        $this->linked_municipalities = $postalCodeArray;
    }
}