<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $visible= ['name', 'slug', 'color'];

    /**
     *  Category consists of tenders
     * 
     * @return hasMany
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    public function getNameAttribute($name)
    {
        return __($name);
    }
}
