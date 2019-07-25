<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    protected $guarded = [];

    /**
     * Get the right logo path
     * 
     * @return string
     */
    public function getLogoAttribute($logo)
    {
        $exists = Storage::disk('public')->exists($logo);

        if ($exists) {
            return '/storage/'. $logo;
        }
        
        return '/storage/build/images/default_logo.svg';    
    }
}
