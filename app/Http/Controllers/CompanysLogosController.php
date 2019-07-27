<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return auth()->user()->company->addAvatar($request);
    }
 
}
