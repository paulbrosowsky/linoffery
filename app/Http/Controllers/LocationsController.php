<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use Illuminate\Support\Collection;

class LocationsController extends Controller
{
    /**
     * Get all Locations
     */
    public function index()
    {      
        // dd(request('route') );
        $locations = collect();

        foreach (request('route') as $area){
            $area = json_decode($area);
            // dd($area);
            $location = Location::whereBetween('latitude', [$area->south, $area->north])
                        ->whereBetween('longitude', [$area->west, $area->east])->get();
            // dd($location->all());
            $locations = $locations->merge($location);
        }
        
        return $locations;
        
    } 

}
