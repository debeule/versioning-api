<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Imports\Queries\Region as RegionContract;

final class Region extends Model implements RegionContract
{
    public $timestamps = false;

    protected $connection = 'kohera-testing';

    use HasFactory;
    
    protected static function newFactory()
    {
        return \Database\Kohera\Factories\RegionFactory::new();
    }

    protected $fillable = [
        'RegionNaam',
        'Provincie',
        'Postcode',
        'RegioDetailId',
    ];

    public function name(): string
    {
        return $this->RegionNaam;
    }

    public function regionId(): int
    {
        return $this->RegioDetailId;
    }

    public function province(): string
    {
        return $this->Provincie;
    }

    public function postalCode(): int
    {
        return (int) $this->Postcode;
    }   
}