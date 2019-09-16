<?php

namespace App\Http\Controllers;

use App\Filters\TenderFilters;
use Illuminate\Http\Request;
use App\Tender;
use App\Location;
use PHPUnit\Framework\MockObject\Stub\ReturnStub;

class TendersController extends Controller
{
    /**
     *  Get all Cargos
     */
    public function index(Request $request, TenderFilters $filters)
    {   
        return Tender::where('published_at', '!=', NULL )
                    ->where('completed_at', '=', NULL)
                    ->latest()
                    ->filter($filters)
                    ->paginate(20);
    }

    /**
     *  Show given Tender 
     * 
     * @param id
     * @return Tender
     */
    public function show(Tender $tender)
    {   
        // Only Owners can view unpublished threads       
        if(!$tender->isActive) {            
            $this->authorize('show', $tender);
        } 
        
        //Load with Offers if tenders owner view the tender
        if($tender->owner()){
            return $tender->load(['offers' => function($query){
                $query->orderBy('price');
            }]);
        }
        // Loa
        return $tender->load(['offers' => function($query){
            $query->where('user_id', auth('api')->id())->orderBy('price');
        }]);
    }

    /**
     * Store Tender in DBä
     * 
     * @param Request
     * @return Tender
     */
    public function store(Request $request)
    {        
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required',            
            'max_price' => 'required|numeric|min:0',
            'immadiate_price' => 'min:0',
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

    /**
     * Set Tender as Completed
     * 
     * @param id
     */
    public function cancel(Tender $tender, Request $request)
    {         
        $this->authorize('show', $tender);

        if($request->withClone){
            return $tender->complete($request->withClone);
        }
    
        $tender->complete();

        return $tender;
    }    

    public function destroy(Tender $tender)
    {
        $this->authorize('destroy', $tender);      

        $tender->forceDelete();  
    }
}
