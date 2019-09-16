<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::created(function($freight){                     
            $freight->tender->updateWeight();            
        });  

        static::deleted(function($freight){
            if(!empty($freight->tender)){
                $freight->tender->updateWeight(); 
            }                        
        });  
    }
    
    /**
     *  A Freight belongs to a Tender
     * 
     * @return belongsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

}
