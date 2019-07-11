<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{

    protected $with = [ 'user', 'locations', 'freights' ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
