<?php

declare(strict_types=1);

namespace App\School;

use App\Extensions\Eloquent\SoftDeletes\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class BillingProfile extends Model
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
        'vat_number',
        'tav',
        'address_id',
        'school_id',
    ];

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function hasChanged(Mixed $importedBillingProfile): bool
    {
        $recordHasChanged = false;

        $recordHasChanged = $recordHasChanged || $billingProfile->record_id !== $importedBillingProfile->recordId();
        $recordHasChanged = $recordHasChanged || $billingProfile->name !== $importedBillingProfile->name();
        $recordHasChanged = $recordHasChanged || $billingProfile->email !== $importedBillingProfile->email();
        $recordHasChanged = $recordHasChanged || $billingProfile->vat_number !== $importedBillingProfile->vatNumber();
        $recordHasChanged = $recordHasChanged || $billingProfile->tav !== $importedBillingProfile->tav();
        $recordHasChanged = $recordHasChanged || $billingProfile->address_id !== $importedBillingProfile->address()->id;
        $recordHasChanged = $recordHasChanged || $billingProfile->school_id !== $importedBillingProfile->school()->id;
        
        return $recordHasChanged;
    }
}