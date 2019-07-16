<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{

    protected $with = [ 'user', 'locations', 'freights' ];

    /**
     * A cargo belong to user
     * 
     * @return belondsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Cargo has many Locations
     * 
     * @return hasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

     /**
     * A Cargo has many Freights
     * 
     * @return hasMany
     */
    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
