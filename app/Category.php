<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    protected $hidden= ['created_at', 'updated_at'];

    /**
     *  Category consists of tenders
     * 
     * @return hasMany
     */
    public function tenders()
    {
        return $this->hasMany(Tender::class);
    }

    /**
     *  Translate categories name
     */
    public function getNameAttribute($name)
    {
        return __($name);
    }

    /**
	* Overwrite the default route key "id"
	*	
	* @return string
	*/
    public function getRouteKeyName()
    {
    	return 'slug';
    }
}
