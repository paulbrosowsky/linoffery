<?php

namespace App;

trait HasCustomId{

    protected static function bootHasCustomId()
    {  
        static::created(function($model){            
            $model->generateCustomId($model);
        });           
    }

    /**
     *  Genetrate Unique Custom ID and save in DB
     * 
     * @param Model 
     */
    protected function generateCustomId($model)
    {
        preg_match('/^.{0,2}/', class_basename($model), $short);

        $number = strtoupper($short[0])
                    .rand(10000, 99999).'-'
                    .rand(10000, 99999);    
            
        $numberExists = $model->whereCustomId($number)->exists();  
        
        if($numberExists){                      
            return $model->generateCustomId($model);
        }  

        $model->update(['custom_id' => $number]);        
    }


    
}
