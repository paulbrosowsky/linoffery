<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Image as IntervantionImage;
use Illuminate\Support\Facades\Storage;

trait HasAvatar{

    protected static function bootHasAvatar()
    {
        static::deleting(function($model){ 
            Storage::disk('public')->delete( $model->avatar );
        });
    }

   /**
     * Store a new logo to the company
     * 
     * @param Request
     * @return response
     */ 
    public function addAvatar($request){        
        $request->validate([
            'image' => 'required | image | max:5000'
        ]);         
        
        Storage::disk('public')->delete($this->getOriginal('avatar')); 

        $image_path = $request->file('image')->store('avatars', 'public');
       
        $this->update([
            'avatar' => $image_path
        ]);
         
        if (env('APP_ENV') !== 'testing') {  
            $this->cropImage($image_path);       
        }
        
        return response()->json(200);
    }

     /**
     * Crop an Image in the Storage
     * 
     * @param string 
     */
    protected function cropImage($path)
    {
        $to_crope = Storage::get('public/'.$path);       

        $croped = IntervantionImage::make($to_crope)->fit(256)->encode(); 
        
        Storage::put('public/'.$path, $croped);  
    }

    /**
     *  Get avatar path for public storage
     * 
     * @param string $avatar
     * @return string
     */
    protected function getAvatarAttribute($avatar)
    {
        return '/storage/'. $avatar;
    }
    
}