<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransportType extends Model
{
    protected $appends = ['name'];

    /**
     *  Get name attribute
     * 
     * @return string
     */
    public function getNameAttribute()
    {
        return __($this->title).' | '.$this->subtitle;
    }
}
