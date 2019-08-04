<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Freight;

class FreightsController extends Controller
{
    /**
     * Store New Freight in  DB
     * 
     * @param Request
     * @return Freight 
     */
    public function store(Request $request)
    {   
        $request->validate([
            'tender_id' => 'required|exists:tenders,id',
            'title' => 'required',
            'pallet' => 'required',
            'weight' => 'required|numeric|max:100000',
            'width' => 'required|numeric|max:10000',
            'height' => 'required|numeric|max:10000',
            'length' => 'required|numeric|max:10000',             
        ]);      

        $freight = Freight::create([            
            
            'tender_id' => $request->tender_id,
            'title' => $request->title,
            'description'=> $request->description,
            'pallet' => $request->pallet,
            'weight' => $request->weight,
            'width' => $request->width,
            'height' => $request->height,
            'length' => $request->length,            

        ]);     

        return $freight;
    }
}
