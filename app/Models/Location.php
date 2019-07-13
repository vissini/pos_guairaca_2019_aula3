<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['country_id', 'latitude', 'longitude'];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
