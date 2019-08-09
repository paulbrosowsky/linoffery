<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tender;
use App\Location;
use Illuminate\Queue\Console\RetryCommand;

class TendersController extends Controller
{
    /**
     *  Get all Cargos
     */
    public function index()
    { 
        // if(request('route')){
        //     $locations = collect();

        //     foreach (request('route') as $area){
        //         $area = json_decode($area); 

        //         $location = Location::whereBetween('lat', [$area->south, $area->north])
        //                     ->whereBetween('lng', [$area->west, $area->east])->get();
                
        //         $locations = $locations->merge($location);
        //     } 

        //     $cargos =$locations->groupBy('cargo_id')
        //         ->filter(function($group, $key){
        //             if($group->count() == 2 ){                       
        //                 return $group;
        //             }
        //         })->map(function($value, $key){
        //             return Cargo::where('id', $key)->get();
        //         })->values();
              
        //     $cargosResult = collect();

        //     foreach ($cargos as $cargo) {
        //         $cargosResult= $cargosResult->merge($cargo);
        //     } 

        //     return  $cargosResult;
        // }   

        return Tender::where('published_at', '!=', NULL )->latest()->paginate(20);
    }

    /**
     *  Show given Tender 
     * 
     * @param id
     * @return Tender
     */
    public function show(Tender $tender)
    {  
        if($tender->published_at === NULL) {
            $this->authorize('show', $tender);
        } 

        return $tender;
    }

    /**
     * Store Tender in DB
     * 
     * @param Request
     * @return Tender
     */
    public function store(Request $request)
    {        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',            
            'max_price' => 'required|numeric',
            'valid_date' => 'required|date'
        ]);
            
        $tender = Tender::create([

            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description'=> $request->description,
            'immediate_price' => $request->immediate_price,
            'max_price' => $request->max_price,
            'valid_date' => $request->valid_date
            
        ]);

        return $tender;
    }


    /**
     *  Update given Tender in DB
     * 
     * @param Tender
     * @param Request 
     * @return Tender
     */
    public function update(Tender $tender, Request $request)
    {
        $this->authorize('update', $tender);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',            
            'max_price' => 'required|numeric',
            'valid_date' => 'required|date'
        ]);

        $tender->update([            
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description'=> $request->description,
            'immediate_price' => $request->immediate_price,
            'max_price' => $request->max_price,
            'valid_date' => $request->valid_date            
        ]);

        return $tender;
    }   

    /**
     *  Publish a given Tender
     * 
     * @param Tender $id
     * @return Tender
     */
    public function publish(Tender $tender)
    {
        $this->authorize('update', $tender); 
        
        if($tender->locations->isEmpty() || $tender->freights->isEmpty())
        {           
            return response()->json(['message' => 'Tenders data are not completed.'], 403);
        } 

        $tender->update(['published_at' => \Carbon\Carbon::now()]);

        return $tender;
    }
}
