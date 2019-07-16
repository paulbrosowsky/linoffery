<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     *  A Location belongs to a Cargo
     * 
     * @return Cargo
     */
    public function cargo()
    {
        return $this->belondsTo(Cargo::class);
    }
}
