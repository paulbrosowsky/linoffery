<?php

namespace App\Filters;

use App\Location;
use App\Tender;
use Carbon\Carbon;

class TenderFilters extends Filters
{
    /**
     * Registered Filters
    */
    protected $filters = ['route', 'location', 'category', 'weight', 'price', 'date'];


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

        $tenderIds = $this->filterByDirection($tenders, $routeFilter->locations);
         
        return  $this->builder->whereIn('id', $tenderIds);
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
                        
        $tenderIds = [];        
        foreach($locations as $pickup){            
            array_push($tenderIds, $pickup->tender->id);
        }
        
        return $this->builder->whereIn('id', $tenderIds);
    }

    /**
     *  Filter Tenders by categories
     * 
     * @param string $list
     * @return Collection
     */
    protected function category($list)
    {          
        $categoryIds = [];

        foreach (json_decode($list) as $category){
            array_push($categoryIds, $category->id);
        } 
        
        return $this->builder->whereIn('category_id', $categoryIds);
    }

    /**
     * Filter Tenders by price range
     * 
     * @param string $values
     * @return Builder
     */
    protected function price($values)
    {
        $range = json_decode($values);

        return $this->builder->whereBetween('max_price', [$range->min, $range->max])
                            ->orWhereBetween('lowest_offer', [$range->min, $range->max]);
    }

    /**
     * Filter Tenders by date range
     * 
     * @param string $values
     * @return Builder
     */
    protected function date($values)
    {
        $range = json_decode($values);

        $from = new Carbon ($range->from);
        $to = new Carbon($range->to); 

        // Find Locations in given date range
        $locations = Location::whereBetween('latest_date', [$from, $to])
                            ->orWhereBetween('earliest_date', [$from, $to])
                            ->get();
        
        // Group Location by tender_id and fing Tenders with 2 Locations
        $tenders = $locations->groupBy('tender_id')                
                        ->filter(function($group, $key){
                            if($group->count() == 2 ){                       
                                return $group;
                            }
                        })
                        ->map(function($value, $key){
                            return Tender::where('id', $key)->first();
                        })
                        ->values(); 

        $tenderIds = [];

        foreach($tenders as $tender){
            array_push($tenderIds, $tender->id);
        }

        return $this->builder->whereIn('id', $tenderIds);                            
    }

    /**
     * Filter Tenders by weight range
     * 
     * @param string $values
     * @return Builder
     */
    protected function weight($values)
    {
        $range = json_decode($values);

        return $this->builder->whereBetween('weight', [$range->min, $range->max]);
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
        
        $results = []; 
        
        foreach($tenders as $tender){                
            $start = $tender->locations->where('type', '=', 'pickup')->first();
            $end =  $tender->locations->where('type', '=','delivery')->first();
            
            // Determin if Tender Location's Directions are positiv or negativ
            $latDirection = $this->sign($end->lat - $start->lat);
            $lngDirection = $this->sign($end->lng - $start->lng);
            
            // Find Route Direction with bigger Differece and compare it with Location Direction
            // If Directions are similar push tenders id to an array
            if($lngDifference > $latDifference){ 
                $lngDirection == $lngRouteDirection ? array_push($results, $tender->id) : '';
            }else{        
                $latDirection == $latRouteDirection ? array_push($results, $tender->id) : '';
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