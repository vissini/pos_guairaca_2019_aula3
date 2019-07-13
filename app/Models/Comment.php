<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['description'];
    public function owner()
    {
        return $this->morphTo();
    }
}
