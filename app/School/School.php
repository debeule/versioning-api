<?php

declare(strict_types=1);

namespace App\School;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use App\Kohera\School as KoheraSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

final class School extends Model
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
        'email',
        'contact_email',
        'type',
        'school_number',
        'institution_id',
        'student_count',
        'address_id',
    ];

    protected $casts = [
        'type' => 'string',
    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function hasChanged(KoheraSchool $koheraSchool): bool
    {
        $recordhasChanged = false;

        $recordhasChanged = $this->name !== $koheraSchool->name();
        $recordhasChanged = $recordhasChanged || $this->email !== $koheraSchool->email();
        $recordhasChanged = $recordhasChanged || $this->contact_email !== $koheraSchool->contactEmail();
        $recordhasChanged = $recordhasChanged || $this->type !== $koheraSchool->type();
        $recordhasChanged = $recordhasChanged || $this->school_number !== $koheraSchool->schoolNumber();
        $recordhasChanged = $recordhasChanged || $this->institution_id !== $koheraSchool->institutionId();
        $recordhasChanged = $recordhasChanged || $this->student_count !== $koheraSchool->studentCount();

        return $recordhasChanged;
    }
}
