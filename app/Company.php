<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasAvatar;

    protected $guarded = [];

    /**
     * Get the right logo path
     * 
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {       
        $exists = Storage::disk('public')->exists($avatar);  
              
        if ($exists) {
            return '/storage/'. $avatar;
        }
        
        return '/storage/build/images/default_logo.svg';    
    }
}
