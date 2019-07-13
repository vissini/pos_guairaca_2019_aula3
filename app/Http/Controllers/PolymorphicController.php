<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\State;
use App\Models\Country;

class PolymorphicController extends Controller
{
    public function polymorphic()
    {
        $city = City::find(1);
        echo "<hr> Cidade: {$city->name} <br>";

        $comments = $city->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }

        $state = State::find(1);
        echo "<hr> Estado: {$state->name} <br>";

        $comments = $state->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }

        $country = Country::find(1);
        echo "<hr> Cidade: {$country->name} <br>";

        $comments = $country->comments;
        foreach ($comments as $comment ) {
            echo $comment->description."<br>";
        }
    }

    public function polymorphicInsert()
    {
        $city = City::find(1);

        $comment = $city->comments()->create([
            'description' => 
                "Comentário para cidade {$city->name} em ".date('d-m-y h:i:s')
        ]);

        $country = Country::find(1);
        $comment = $country->comments()->create([
            'description' => "Comentário para País {$country->name} em ".date('d-m-y h:i:s')
        ]);

        $state = State::find(1);
        $comment = $state->comments()->create([
            'description' => "Comentário para Estado {$state->name} em ".date('d-m-y h:i:s')
        ]);









        dd($comment->description);
    }
}
