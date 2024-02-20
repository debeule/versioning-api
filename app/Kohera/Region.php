<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Database\Kohera\Factories\RegionFactory;
use App\Imports\Queries\Region as RegionContract;

final class Region extends Model implements RegionContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    protected $fillable = [
        'RegionNaam',
        'Provincie',
        'Postcode',
        'RegioDetailId',
    ];

    public function regionId(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->RegionNaam;
    }

    public function regionNumber(): int
    {
        return $this->RegioDetailId;
    }

    public function postalCode(): int
    {
        return (int) $this->Postcode;
    }   
}