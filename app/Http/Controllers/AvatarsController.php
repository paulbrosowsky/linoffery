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
        return auth()->user()->addAvatar($request);
    }
    
}
