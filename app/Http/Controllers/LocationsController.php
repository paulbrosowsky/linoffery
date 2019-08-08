<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Tender;

class LocationsController extends Controller
{
    
    /**
     *  Store New Loation in DB
     * 
     * @param Raquest
     * @return Location
     */
    public function store(Request $request)
    {
        $request->validate([
            'tender_id' => 'required|exists:tenders,id',
            'type' => ['required', Rule::in(['pickup', 'delivery'])],
            'address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'latest_date' => 'required|date',
            'earliest_date' => 'required|date',
        ]);

        $location = Location::create([ 
            'tender_id' => $request->tender_id,
            'type' => $request->type,
            'address'=> $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'latest_date' => $request->latest_date,
            'earliest_date' => $request->earliest_date,
            'latency' => $request->latency,
            'loading' => $request->loading,
        ]);

        return $location;
    }

    /**
     * Update given Tender in DB
     * 
     * @param Locaiton
     * @param Request
     * @return Locaiton 
     */
    public function update(Location $location, Request $request)
    {
        $this->authorize('update', $location->tender);

        $request->validate([  
            'address' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
            'latest_date' => 'required|date',
            'earliest_date' => 'required|date',            
        ]);       
        
        $location->update([          
            'address'=> $request->address,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'latest_date' => $request->latest_date,
            'earliest_date' => $request->earliest_date,
            'latency' => $request->latency,
            'loading' => $request->loading,
        ]); 
        
        return $location;
    }
}
