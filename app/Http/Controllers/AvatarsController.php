<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image as IntervantionImage;

class AvatarsController extends Controller
{
     /**
     * Store a new user avatar
     * 
     * @param Request
     * @return response
     */    
    public function store(Request $request)
    {          
        $request->validate([
            'image' => 'required | image'
        ]); 
        
        Storage::disk('public')->delete(auth()->user()->getOriginal('avatar')); 

        
        $image_path = $request->file('image')->store('avatars', 'public');
        
        if (env('APP_ENV') !== 'testing') {  
            $this->cropImage($image_path);       
        }
        auth()->user()->update([
            'avatar' => $image_path
        ]);
        
        return auth()->user()->avatar;
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

    
}
