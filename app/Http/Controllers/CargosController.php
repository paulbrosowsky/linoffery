<?php

namespace App\Http\Controllers;

use App\Cargo;
use App\Location;

class CargosController extends Controller
{
    /**
     *  Get all Cargos
     */
    public function index()
    { 
        if(request('route')){
            $locations = collect();

            foreach (request('route') as $area){
                $area = json_decode($area); 

                $location = Location::whereBetween('lat', [$area->south, $area->north])
                            ->whereBetween('lng', [$area->west, $area->east])->get();
                
                $locations = $locations->merge($location);
            } 

            $cargos =$locations->groupBy('cargo_id')
                ->filter(function($group, $key){
                    if($group->count() == 2 ){                       
                        return $group;
                    }
                })->map(function($value, $key){
                    return Cargo::where('id', $key)->get();
                })->values();
              
            $cargosResult = collect();

            foreach ($cargos as $cargo) {
                $cargosResult= $cargosResult->merge($cargo);
            } 

            return  $cargosResult;
        }   

        return Cargo::all();
    }

    /**
     * Get a given Cargo
     */
    public function show(Cargo $cargo)
    {        
        return $cargo;
    }
}
