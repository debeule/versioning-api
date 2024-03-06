<?php

declare(strict_types=1);

namespace Database\Kohera\Seeders;

use Database\Kohera\Factories\SchoolFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolSeeder extends Seeder
{
    protected $connection = 'kohera-testing';
    
    public function run(): void
    {
        SchoolFactory::new()
            ->count(50)
            ->create();

        DB::connection('kohera-testing')->table('schools')->insert([
            [
                "Place_id" => "-1",
                "Name" => "Sint-Norbertusinstituut 1",
                "Gangmaker_mail" => "ann.vanwinkel@snorduffel.be",
                "School_mail" => "mail@snorduffel.be",
                "address" => "Stationsstraat 6",
                "Student_Count" => "1368",
                "School_Id" => "100003",
                "Instellingsnummer" => "126003",
                "Postcode" => "2570",
                "Gemeente" => "Duffel",
                "Type" => "SO",
                "Facturatie_Naam" => "",
                "Facturatie_tav" => "",
                "Facturatie_Adres" => "",
                "Facturatie_Postcode" => "",
                "Facturatie_Gemeente" => "",
                "BTWNummer" => "",
                "Facturatie_Email" => "",
            ],
            [
                "Place_id" => "-1",
                "Name" => "Berthoutinstituut - Klein Seminarie 2",
                "Gangmaker_mail" => "jorien.torfs@bimsem.be",
                "School_mail" => "info@bimsem.be",
                "address" => "Bleekstraat 3",
                "Student_Count" => "1135",
                "School_Id" => "100004",
                "Instellingsnummer" => "47894",
                "Postcode" => "2800",
                "Gemeente" => "Mechelen",
                "Type" => "SO",
                "Facturatie_Naam" => "",
                "Facturatie_tav" => "",
                "Facturatie_Adres" => "",
                "Facturatie_Postcode" => "",
                "Facturatie_Gemeente" => "",
                "BTWNummer" => "",
                "Facturatie_Email" => "",
            ],
            [
                "Place_id" => "-1",
                "Name" => "Colomaplus bovenbouw 2",
                "Gangmaker_mail" => "bert.nys3@gmail.com",
                "School_mail" => "info@colomaplus.be",
                "address" => "Tervuursesteenweg 2",
                "Student_Count" => "945",
                "School_Id" => "100006",
                "Instellingsnummer" => "30866",
                "Postcode" => "2800",
                "Gemeente" => "Mechelen",
                "Type" => "SO",
                "Facturatie_Naam" => "",
                "Facturatie_tav" => "",
                "Facturatie_Adres" => "",
                "Facturatie_Postcode" => "",
                "Facturatie_Gemeente" => "",
                "BTWNummer" => "",
                "Facturatie_Email" => "",
            ],
        ]);
    }
}