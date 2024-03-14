<?php


declare(strict_types=1);

namespace App\School\Commands;

use App\Kohera\School as KoheraSchool;
use App\School\School;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSchool
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSchool $koheraSchool
    ) {}

    public function handle(): bool
    {
        if (! $this->recordExists($this->koheraSchool)) 
        {
            return $this->buildRecord($this->koheraSchool);
        }
        
        if ($this->recordHasChanged($this->koheraSchool)) 
        {
            return $this->createNewRecordVersion($this->koheraSchool);
        }

        return false;
    }

    private function recordExists(KoheraSchool $koheraSchool): bool
    {
        return School::where('record_id', $koheraSchool->recordId())->exists();
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {        
        $newSchool = new School();
        
        $newSchool->record_id = $koheraSchool->recordId();
        $newSchool->name = $koheraSchool->name();
        $newSchool->email = $koheraSchool->email();
        $newSchool->contact_email = $koheraSchool->contactEmail();
        $newSchool->type = $koheraSchool->type();
        $newSchool->school_number = $koheraSchool->schoolNumber();
        $newSchool->institution_id = $koheraSchool->institutionId();
        $newSchool->student_count = $koheraSchool->studentCount();
        $newSchool->address_id = $koheraSchool->address()->id;
        
        return $newSchool->save();
    }

    private function recordHasChanged(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('record_id', $koheraSchool->recordId())->first();
        
        $recordhasChanged = false;

        $recordhasChanged = $school->name !== $koheraSchool->name();
        $recordhasChanged = $recordhasChanged || $school->email !== $koheraSchool->email();
        $recordhasChanged = $recordhasChanged || $school->contact_email !== $koheraSchool->contactEmail();
        $recordhasChanged = $recordhasChanged || $school->type !== $koheraSchool->type();
        $recordhasChanged = $recordhasChanged || $school->school_number !== $koheraSchool->schoolNumber();
        $recordhasChanged = $recordhasChanged || $school->institution_id !== $koheraSchool->institutionId();
        $recordhasChanged = $recordhasChanged || $school->student_count !== $koheraSchool->studentCount();

        return $recordhasChanged;
    }

    private function createNewRecordVersion(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('record_id', $koheraSchool->recordId())->delete();

        return $this->buildRecord($koheraSchool);
    }
}