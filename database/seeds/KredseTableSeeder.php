<?php

use App\Kreds;
use Illuminate\Database\Seeder;

class KredseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('kredse.json');
        $data = json_decode($json);
        foreach($data as $obj){
            Kreds::create([
                'id' => $obj->Number,
                'key' => $obj->Id,
                'navn' => $obj->Name,
                'website' => $obj->Website,
                'stednavn' => $obj->MeetingLocation->Name,
                'adresse' => $obj->MeetingLocation->StreetName,
                'postnr' => $obj->MeetingLocation->PostalCode,
                'bynavn' => $obj->MeetingLocation->PostalDistrictName,
                'latitude' => $obj->MeetingLocation->Latitude,
                'longitude' => $obj->MeetingLocation->Longitude,
                'kontakt_navn' => $obj->ContactPerson->PersonWS->Name ?? null,
                'kontakt_email' => $obj->ContactPerson->PersonWS->Email ?? null,
                'kontakt_telefon' => $obj->ContactPerson->PersonWS->Phone ?? null,
            ]);
        }
    }
}
