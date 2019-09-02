<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class Company extends Model
{
    use HasAvatar, HasCustomId;

    protected $guarded = [];

    protected $appends = ['completed'];

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

    /**
     *  Check if company has a full address
     * 
     * @return boolean
     */
    public function getCompletedAttribute()
    {        
        return !empty($this->address && $this->postcode && $this->city && $this->country);
    }
}
