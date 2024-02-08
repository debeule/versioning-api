<?php 

namespace App\Schools\Commands;

use App\Schools\School;
use App\Kohera\DwhSchool;


final class CreateNewProvinceCommand
{
    public function __invoke(DwhSchool $dwhSchool): bool
    {
        $newSchool = new School();
                
        $newSchool->name = $dwhSchool->Name;
        $newSchool->email = $dwhSchool->School_mail;
        $newSchool->contact_email = $dwhSchool->Gangmaker_mail;
        $newSchool->type = $dwhSchool->type;
        $newSchool->school_id = $dwhSchool->School_Id;
        $newSchool->student_count = $dwhSchool->Student_Count;
        $newSchool->institution_id = $dwhSchool->Instellingsnummer;
        
        $addressId = Address::where('street_name', explode(' ', $DwhSchool->address)[0])->first()->id;
        $newSchool->address_id = $addressId;
        $newSchool->save();
    }
}