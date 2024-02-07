<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Schools\School;
use App\Schools\Province;
use App\Schools\Region;
use App\Schools\Municipality;
use App\Schools\Address;
use App\Kohera\Queries\GetAllDwhRegionsQuery;
use App\Kohera\Queries\GetAllDwhSchoolsQuery;

class SyncSchoolsDomainJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        //regions
        $existingRegions = Region::all();
        $getAllDwhRegionsQuery = new GetAllDwhRegionsQuery();
        foreach ($getAllDwhRegionsQuery() as $key => $DwhRegion) 
        {
            $regionExists = $existingRegions->where('name', $DwhRegion->RegionNaam)->isNotEmpty();
            
            if ($regionExists)
            {
                $existingRegions = $existingRegions->where('name', "!=", $DwhRegion->RegionNaam);

                continue;
            }

            if (!$regionExists) 
            {
                if (!Province::where('name', $DwhRegion->RegionNaam)->first())
                {
                    $newProvince = new Province();
                    $newProvince->name = $DwhRegion->Provincie;
                    $newProvince->save();
                }
                
                $newRegion = new Region();
                $newRegion->name = $DwhRegion->RegionNaam;
                $newRegion->region_id = $DwhRegion->RegioDetailId;
                $newRegion->province_id = Province::where('name', $DwhRegion->Provincie)->first()->id;
                $newRegion->save();
            }
        }


        //schools
        $existingSchools = School::all();
        
        $getAllDwhSchoolsQuery = new GetAllDwhSchoolsQuery();
        foreach ($getAllDwhSchoolsQuery() as $key => $DwhSchool) 
        {
            $schoolExists = $existingSchools->where('school_id', $DwhSchool->School_Id)->isNotEmpty();

            if ($schoolExists)
            {
                $existingSchools = $existingSchools->where('name', "!=", $DwhSchool->School_Id);

                continue;
            }

            if (!$schoolExists) 
            {
                //maak municipality van adres
                $newMunicipality = new Municipality();
                $newMunicipality->name = $DwhSchool->Gemeente;
                $newMunicipality->postal_code = $DwhSchool->Postcode;
                $newMunicipality->save();

                //maak adress van school
                $addressArray = explode(' ', $DwhSchool->address);
                
                $newAdress = new Address();
                $newAdress->street_name = $addressArray[0];
                $newAdress->street_identifier = $addressArray[1];
                $newAdress->municipality_id = Municipality::where('name', $DwhSchool->Gemeente)->first()->id;
                $newAdress->save();


                $newSchool = new School();
                
                $newSchool->name = $DwhSchool->Name;
                $newSchool->email = $DwhSchool->School_mail;
                $newSchool->contact_email = $DwhSchool->Gangmaker_mail;
                $newSchool->type = $DwhSchool->type;
                $newSchool->school_id = $DwhSchool->School_Id;
                $newSchool->student_count = $DwhSchool->Student_Count;
                $newSchool->institution_id = $DwhSchool->Instellingsnummer;

                $addressId = Address::where('street_name', explode(' ', $DwhSchool->address)[0])->first()->id;
                $newSchool->address_id = $addressId;
                $newSchool->contact_id = 
                $newSchool->save();
                
            }
        }

        foreach ($existingSchools as $existingSchool) 
        {
            $existingSchool->delete();
        }
    }
}
