<?php

declare(strict_types=1);

namespace App\Kohera;

use App\Imports\Queries\Region as RegionContract;
use App\Imports\Sanitizer\Sanitizer;
use Illuminate\Database\Eloquent\Model;

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

    public function recordId(): int
    {
        return Sanitizer::input($this->RegioDetailId)->numericValue();
    }

    public function name(): string
    {
        return Sanitizer::input($this->RegionNaam)->stringToLower()->value();
    }

    public function regionNumber(): int
    {
        return Sanitizer::input($this->RegioDetailId)->numericValue();
    }

    public function postalCode(): int
    {
        return Sanitizer::input($this->Postcode)->numericValue();
    }   
}