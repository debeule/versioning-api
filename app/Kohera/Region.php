<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Database\Kohera\Factories\RegionFactory;
use App\Imports\Queries\Region as RegionContract;
use App\Imports\Sanitizer\Sanitizer;

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
        return Sanitizer::input($this->id)->intValue();
    }

    public function name(): string
    {
        return Sanitizer::input($this->RegionNaam)->stringToLower()->value();
    }

    public function regionNumber(): int
    {
        return Sanitizer::input($this->RegioDetailId)->intValue();
    }

    public function postalCode(): int
    {
        return Sanitizer::input($this->Postcode)->intValue();
    }   
}