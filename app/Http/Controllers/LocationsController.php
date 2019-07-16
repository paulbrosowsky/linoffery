<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Collection;
use App\Cargo;


class LocationsController extends Controller
{
    /**
     * Get all Locations
     */
    public function index()
    {   
        $locations = Location::all();  
        
        return $locations;
        
    } 

}
