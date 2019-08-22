<?php

namespace App\Filters;

use App\Location;
use App\Tender;

class TenderFilters extends Filters
{
    /**
     * Registered Filters
    */
    protected $filters = ['route', 'location'];


    /**
     *  Filter Tenders along the given route and between given bounds
     * 
     *  @param string $route
     * @return Collection 
     */
    protected function route($route)
    {        
        $routeFilter = json_decode($route);

        $tenders = $this->findTenders($routeFilter->bounds);

        $results = $this->filterByDirection($tenders, $routeFilter->locations);
         
        return  $this->builder = $results;
    }

    /**
     * Filter Tenders near by user location
     * 
     * @param string
     * @return Collection
     */
    protected function location($location)
    {
        $bounds = json_decode($location);
        
        // Find pickup locations in the given bounds
        $locations = Location::where('type', 'pickup')
                        ->whereBetween('lat', [$bounds->south, $bounds->north])
                        ->whereBetween('lng', [$bounds->west, $bounds->east])                        
                        ->get();
                        
        $tenders = collect();
        // Push all tenders of found to results
        foreach($locations as $pickup){
            $tenders = $tenders->push($pickup->tender);
        }

        return $this->builder = $tenders;
    }

    /**
     *  Find Tenders in given Route Bounds
     * 
     * @param array $bounds     
     * @return Collection
     */
    protected function findTenders($bounds)
    {
        $locations = collect();

        foreach ($bounds as $area){
            // Find Location between the route borders
            $location = Location::whereBetween('lat', [$area->south, $area->north])
                        ->whereBetween('lng', [$area->west, $area->east])
                        ->get();                
            $locations = $locations->merge($location);
        } 

        //Group Locations by Tender ID and find Tenders with this IDs 
        return $locations->groupBy('tender_id')                
                    ->filter(function($group, $key){
                        if($group->count() == 2 ){                       
                            return $group;
                        }
                    })
                    ->map(function($value, $key){
                        return Tender::where('id', $key)->first();
                    })
                    ->values(); 
    }


    /**
     *  Get Tenders with similad direction like the give Route
     * 
     * @param Collection $tenders
     * @param array $locations
     * @return Collection $results
     */
    protected function filterByDirection($tenders, $locations)
    {
        
        // Find absolute Difference on Lat and Lng between Route Origin and Destination 
        $lngDifference = abs(abs($locations->end->lng) - abs($locations->start->lng)); 
        $latDifference = abs(abs($locations->end->lat) - abs($locations->start->lat)); 
        // Determin if Route Directions are positiv or negativ
        $lngRouteDirection = $this->sign($locations->end->lng - $locations->start->lng);
        $latRouteDirection = $this->sign($locations->end->lat - $locations->start->lat);
        
        $results = collect(); 
        
        foreach($tenders as $result){                
            $start = $result->locations->where('type', '=', 'pickup')->first();
            $end =  $result->locations->where('type', '=','delivery')->first();
            
            // Determin if Tender Location's Directions are positiv or negativ
            $latDirection = $this->sign($end->lat - $start->lat);
            $lngDirection = $this->sign($end->lng - $start->lng);
            
            // Find Route Direction with bigger Differece and compare it with Location Direction
            // If Directions are similar push it to Results
            if($lngDifference > $latDifference){ 
                $lngDirection == $lngRouteDirection ? $results = $results->push($result) : '';
            }else{        
                $latDirection == $latRouteDirection ? $results = $results->push($result) : '';
            }                 
        }

        return $results;
    }

    /**
     * Detect if the number positiv or negative
     *  
     * @param number
     * @return 1, 0, -1
     */
    protected  function sign($num) {
        return ($num > 0) ? 1 : (($num < 0) ? -1 : 0);
    }
  

}