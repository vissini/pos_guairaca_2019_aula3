<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Location;

class OneToOneController extends Controller
{
    public function oneToOneInsert()
    {
        $dataForm = [
            'name' => 'Belgica',
            'latitude' => '7899',
            'longitude' => '9879',
        ];

        
        $country = Country::find(5);
        $location = $country->location()->create($dataForm);
        var_dump($location);
        // $dataForm['country_id'] = $country->id;
        // $location = Location::create($dataForm);
    }

    public function oneToOneInverse()
    {
        $latitude = 123;
        $longitude = 321;

        $location = Location::where('latitude', $latitude)->
        where('longitude', $longitude)->
        get()->first();
        echo $location->id;
        

        $country = $location->country;
        echo $country->name;
    }

    public function oneToOne()
    {
        $country = Country::where('name','Brasil')->get()->first();
        //$country = Country::find(1);
        echo $country->name."<br>";
        
        $location = $country->location()->get()->first();
        echo "Latitude {$location->latitude} - Longitude {$location->longitude}";
    }
}
