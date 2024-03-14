<?php

declare(strict_types=1);

namespace App\Location;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Kohera\Region as KoheraRegion;

final class Region extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'record_id',
        'name',
        'region_number',
    ];

    #TODO: check / redo all relations between models
    public function subregions(): HasMany
    {
        return $this->hasMany(Region::class, 'record_id');
    }

    public function hasChanged(KoheraRegion $koheraRegion): bool
    {
        $recordhasChanged = false;

        $recordhasChanged = $recordhasChanged || $this->name !== $koheraRegion->name();
        $recordhasChanged = $recordhasChanged || $this->region_number !== $koheraRegion->regionNumber();

        return $recordhasChanged;
    }
}