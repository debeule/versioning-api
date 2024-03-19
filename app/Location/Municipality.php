<?php

declare(strict_types=1);

namespace App\Location;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use App\School\Address;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Municipality extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'record_id',
        'name',
        'postal_code',
        'province',
        'head_municipality',
        'region_id',
    ];

    public function address(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function region() : BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function hasChanged(Mixed $importedMunicipality): bool
    {
        $recordHasChanged = false;
        
        $recorHhasChanged = $this->name !== $importedMunicipality->name();
        $recordHasChanged = $recordHasChanged || $this->province !== $importedMunicipality->province();

        if (! is_null($importedMunicipality->headMunicipality())) 
        {
            $recordHasChanged = $recordHasChanged || $this->head_municipality !== $importedMunicipality->headMunicipality();
        }
        
        return $recordHasChanged;
    }
}
