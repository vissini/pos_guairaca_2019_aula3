<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public function comments()
    {
        return $this->morphMany(Comment::class, 'owner');
    }
    
    public function companies()
    {
        return $this->belongsToMany(Company::class);
    }
}
