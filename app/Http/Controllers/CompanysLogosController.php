<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image as IntervantionImage;
use Illuminate\Support\Facades\Storage;

class CompanysLogosController extends Controller
{
       /**
     * Store a new logo to the company
     * 
     * @param Request
     * @return response
     */    
    public function store(Request $request)
    {          
        $request->validate([
            'image' => 'required | image'
        ]); 
        
        Storage::disk('public')->delete(auth()->user()->company->getOriginal('logo')); 

        $image_path = $request->file('image')->store('logos', 'public');
       
        auth()->user()->company->update([
            'logo' => $image_path
        ]);
         
        if (env('APP_ENV') !== 'testing') {  
            $this->cropImage($image_path);       
        }
        
        return auth()->user()->company->logo;
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
