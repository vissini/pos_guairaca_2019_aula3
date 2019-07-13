<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;

class OneToManyController extends Controller
{

    public function hasManyThrough()
    {
        $country = Country::find(1);
        echo "<b>{$country->name}</b><br>";
        $cities = $country->cities;
        foreach ($cities as $city)  {
            echo " {$city->name}, ";
        }
        echo "<hr>"; 
        echo "Número de cidades = ".$cities->count();
    }

    public function oneToManyInsert()
    {
        // $dataForm = [
        //     'name' => 'Ceará',
        //     'initials' => 'CE'
        // ];

        // $country = Country::find(1);

        // $insertState = $country->states()->create($dataForm);
        // dd($insertState);

        $dataForm = [
            'name' => 'Rio Grande do Sul',
            'initials' => 'RS',
            'country_id' => '1',
        ];

        $insertState = State::create($dataForm);
        dd($insertState);

    }

    public function manyToOne()
    {
        $stateName = 'Paraná';
        $state = State::where('name', $stateName)->first();

        echo "<b>{$state->name}</b><br>";

        $country = $state->country;
        echo $country->name;
    }

    public function oneToMany()
    {
        $keysearch = 'a';
        $countries = Country::where('name', 'like', "%{$keysearch}%")->
        with('states')->get();

        dd($countries);

        foreach ($countries as $country){
            echo "<hr> {$country->name}";
            $states = $country->states;

            foreach ($states as $state){
                echo "<br> {$state->initials} - {$state->name}";
            }
        }

        // $keysearch = 'a';
        // $countries = Country::where('name', 'like', "%{$keysearch}%")->get();

        // foreach ($countries as $country){
        //     echo "<hr> {$country->name}";
        //     $states = $country->states;

        //     foreach ($states as $state){
        //         echo "<br> {$state->initials} - {$state->name}";
        //     }
        // }

        // $country = Country::where('name', 'Brasil')->first();

        // //$states = $country->states;
        // $states = $country->states()->
        // where('initials', 'like', '%S%')->get();

        // foreach ($states as $state){
        //     echo "<hr> {$state->initials} - {$state->name}";
        // }

    }   
}
