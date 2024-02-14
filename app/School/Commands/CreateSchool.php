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
        return School::where('school_id', $koheraSchool->School_Id)->exists();
    }

    private function recordHasChanged(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('school_id', $koheraSchool->School_Id)->first();

        $recordhasChanged = false;
        while (!$recordhasChanged)
        {
            $recordhasChanged = $school->name !== $koheraSchool->name;
            $recordhasChanged = $school->email !== $koheraSchool->email;
            $recordhasChanged = $school->contact_email !== $koheraSchool->contact_email;
            $recordhasChanged = $school->type !== $koheraSchool->type;
            $recordhasChanged = $school->student_count !== $koheraSchool->student_count;
            $recordhasChanged = $school->institution_id !== $koheraSchool->institution_id;
        }

        return $recordhasChanged;
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {        
        $newSchool = new School();

        $newSchool->name = $koheraSchool->name;
        $newSchool->email = $koheraSchool->email;
        $newSchool->contact_email = $koheraSchool->contact_email;
        $newSchool->type = $koheraSchool->type;
        $newSchool->school_id = $koheraSchool->school_id;
        $newSchool->student_count = $koheraSchool->student_count;
        $newSchool->institution_id = $koheraSchool->institution_id;
        
        $addressId = Address::where('street_name', explode(' ', $koheraSchool->address)[0])->first()->id;
        $newSchool->address_id = $addressId;
        
        return $newSchool->save();
    }

    public function createNewRecordVersion(KoheraSchool $koheraSchool): bool
    {
        $school = School::where('school_id', $koheraSchool->School_Id)->delete();

        return $this->buildRecord($koheraSchool);
    }
}