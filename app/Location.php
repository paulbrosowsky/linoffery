<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     *  A Location belongs to a Tender
     * 
     * @return belongsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }
}
