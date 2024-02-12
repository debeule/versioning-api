<?php 

declare(strict_types=1);

namespace App\Schools\Commands;

use App\Schools\School;
use App\Kohera\DwhSchool;
use App\Schools\Address;

final class CreateNewSchool
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        if (!$this->recordExists($dwhSchool)) 
        {
            return $this->buildRecord($dwhSchool);
        }
        
        if ($this->recordExists($dwhSchool) && $this->recordHasChanged($dwhSchool)) 
        {
            return $this->createNewRecordVersion($dwhSchool);
        }
    }

    private function recordExists(DwhSchool $dwhSchool): bool
    {
        return School::where('school_id', $dwhSchool->School_Id)->exists();
    }

    private function recordHasChanged(DwhSchool $dwhSchool): bool
    {
        $school = School::where('school_id', $dwhSchool->School_Id)->first();

        $recordhasChanged = false;
        while (!$recordhasChanged)
        {
            $recordhasChanged = $school->name !== $dwhSchool->Name;
            $recordhasChanged = $school->email !== $dwhSchool->School_mail;
            $recordhasChanged = $school->contact_email !== $dwhSchool->Gangmaker_mail;
            $recordhasChanged = $school->type !== $dwhSchool->type;
            $recordhasChanged = $school->student_count !== $dwhSchool->Student_Count;
            $recordhasChanged = $school->institution_id !== $dwhSchool->Instellingsnummer;
        }

        return $recordhasChanged;
    }

    private function buildRecord(DwhSchool $dwhSchool): bool
    {
        $newSchool = new School();

        $newSchool->name = $dwhSchool->Name;
        $newSchool->email = $dwhSchool->School_mail;
        $newSchool->contact_email = $dwhSchool->Gangmaker_mail;
        $newSchool->type = $dwhSchool->type;
        $newSchool->school_id = $dwhSchool->School_Id;
        $newSchool->student_count = $dwhSchool->Student_Count;
        $newSchool->institution_id = $dwhSchool->Instellingsnummer;
        
        $addressId = Address::where('street_name', explode(' ', $dwhSchool->address)[0])->first()->id;
        $newSchool->address_id = $addressId;
        
        return $newSchool->save();
    }

    public function createNewRecordVersion(DwhSchool $dwhSchool): bool
    {
        $school = School::where('school_id', $dwhSchool->School_Id)->delete();

        return $this->buildRecord($dwhSchool);
    }
}