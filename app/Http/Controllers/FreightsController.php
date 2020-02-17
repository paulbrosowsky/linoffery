<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Freight;
use App\Tender;

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
        $tender = Tender::where('id', $request->freights[0]['tender_id'] )->first();  
              
        $this->authorize('update', $tender);      

        $request->validate([
            'freights.*.tender_id' => 'required|exists:tenders,id',
            'freights.*.title' => 'required',
            'freights.*.transport_type_id' => 'required',
            'freights.*.weight' => 'required|numeric|max:100000',
            'freights.*.width' => 'max:10000',
            'freights.*.height' => 'max:10000',
            'freights.*.depth' => 'max:10000',             
        ]); 
        
        if($tender->freights->count() > 0){            
            $tender->freights->each(function($tender){
                $tender->delete();
            });
        } 

        foreach ($request->freights as $freight) {            
            Freight::create([ 
                'tender_id' => $freight['tender_id'],
                'transport_type_id' => $freight['transport_type_id'],
                'title' => $freight['title'],
                'description'=> $freight['description'],                
                'weight' => $freight['weight'],
                'width' => $freight['width'],
                'height' => $freight['height'],
                'depth' => $freight['depth'], 
            ]); 
        }
    }   
}
