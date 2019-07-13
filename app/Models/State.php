<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['initials', 'name', 'country_id'];
    public function country()
    {
        return $this->belongsTo (Country::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'owner');
    }
	
}
