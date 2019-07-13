<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Company;

class ManyToManyController extends Controller
{
    public function ManyToManyInsert()
    {
        $dataForm = [1,2,3];
        
        $company = Company::find(1);
        echo $company->name."<br>";
        $company->cities()->detach(3);
        $cities = $company->cities;
        foreach ($cities as $city ) {
            echo " {$city->name}, ";
        }
        // $dataForm = [1,2,3];
        
        // $company = Company::find(1);
        // echo $company->name."<br>";
        // $company->cities()->sync($dataForm);
        // $cities = $company->cities;
        // foreach ($cities as $city ) {
        //     echo " {$city->name}, ";
        // }
        // $dataForm = [2,3,4];
        
        // $company = Company::find(1);
        // echo $company->name."<br>";
        // $company->cities()->attach($dataForm);
        // $cities = $company->cities;
        // foreach ($cities as $city ) {
        //     echo " {$city->name}, ";
        // }
    }

    public function ManyToManyInverse()
    {
        $company = Company::find(2);
        echo $company->name."<br>";
        $cities = $company->cities;
        foreach ($cities as $city) {
            echo " {$city->name},";
        }
    }


    public function manyToMany()
    {
        $city = City::find(2);
        echo $city->name."<br>";
        $companies = $city->companies;
        foreach ($companies as $company ) {
            echo " {$company->name}, ";
        }
    }
}
