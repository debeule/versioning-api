<?php

declare(strict_types=1);

namespace App\Kohera;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

final class Region extends Model
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
}