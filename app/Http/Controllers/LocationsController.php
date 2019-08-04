<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LocationsController extends Controller
{
  
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



}
