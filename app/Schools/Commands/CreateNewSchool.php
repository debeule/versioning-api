<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\School;
use App\Kohera\KoheraSchool;
use App\Schools\Address;

final class CreateNewSchool
{
    public function __invoke(KoheraSchool $koheraSchool): bool
    {
        if (!$this->recordExists($koheraSchool)) 
        {
            return $this->buildRecord($koheraSchool);
        }
        
        if ($this->recordExists($koheraSchool) && $this->recordHasChanged($koheraSchool)) 
        {
            return $this->createNewRecordVersion($koheraSchool);
        }
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
            $recordhasChanged = $school->name !== $koheraSchool->Name;
            $recordhasChanged = $school->email !== $koheraSchool->School_mail;
            $recordhasChanged = $school->contact_email !== $koheraSchool->Gangmaker_mail;
            $recordhasChanged = $school->type !== $koheraSchool->type;
            $recordhasChanged = $school->student_count !== $koheraSchool->Student_Count;
            $recordhasChanged = $school->institution_id !== $koheraSchool->Instellingsnummer;
        }

        return $recordhasChanged;
    }

    private function buildRecord(KoheraSchool $koheraSchool): bool
    {
        $newSchool = new School();

        $newSchool->name = $koheraSchool->Name;
        $newSchool->email = $koheraSchool->School_mail;
        $newSchool->contact_email = $koheraSchool->Gangmaker_mail;
        $newSchool->type = $koheraSchool->type;
        $newSchool->school_id = $koheraSchool->School_Id;
        $newSchool->student_count = $koheraSchool->Student_Count;
        $newSchool->institution_id = $koheraSchool->Instellingsnummer;
        
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