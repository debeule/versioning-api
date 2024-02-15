<?php 

declare(strict_types=1);

namespace App\School\Commands;

use App\School\School;
use App\Kohera\School as KoheraSchool;
use App\School\Address;
use Illuminate\Foundation\Bus\DispatchesJobs;


final class CreateSchool
{
    use DispatchesJobs;

    public function __construct(
        public KoheraSchool $koheraSchool
    ) {}

    public function handle(): bool
    {
        if (!$this->recordExists($this->koheraSchool)) 
        {
            return $this->buildRecord($this->koheraSchool);
        }
        
        if ($this->recordExists($this->koheraSchool) && $this->recordHasChanged($this->koheraSchool)) 
        {
            $this->createNewRecordVersion($this->koheraSchool);

            return true;
        }

        return true;
    }

    private function recordExists(KoheraSchool $koheraSchool): bool
    {
        return School::where('school_id', $koheraSchool->schoolId())->exists();
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {        
        $newSchool = new School();
        
        $newSchool->name = $koheraSchool->name();
        $newSchool->email = $koheraSchool->email();
        $newSchool->contact_email = $koheraSchool->contactEmail();
        $newSchool->type = $koheraSchool->type();
        $newSchool->schoolNumber = $koheraSchool->schoolNumber();
        $newSchool->student_count = $koheraSchool->studentCount();
        $newSchool->institution_id = $koheraSchool->institutionId();
        
        $addressId = Address::where('street_name', $koheraSchool->address()->street_name)->first()->id;
        $newSchool->address_id = $addressId;
        
        return $newSchool->save();
    }

    private function recordHasChanged(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('school_number', $koheraSchool->schoolNumber())->first();

        $recordhasChanged = false;

        $recordhasChanged = $school->name !== $koheraSchool->name();
        $recordhasChanged = $school->email !== $koheraSchool->email();
        $recordhasChanged = $school->contact_email !== $koheraSchool->contactEmail();
        $recordhasChanged = $school->type !== $koheraSchool->type();
        $recordhasChanged = $school->student_count !== $koheraSchool->studentCount();
        $recordhasChanged = $school->institution_id !== $koheraSchool->institutionId();

        return $recordhasChanged;
    }

    public function createNewRecordVersion(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('school_number', $koheraSchool->schoolNumber())->delete();

        return $this->buildRecord($koheraSchool);
    }
}