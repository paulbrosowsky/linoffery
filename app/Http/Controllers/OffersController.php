<?php

namespace App\Http\Controllers;

use App\Jobs\AcceptOfferJob;
use App\Offer;
use App\Order;
use App\Tender;
use Illuminate\Http\Request;

class OffersController extends Controller
{

    /**
     *  Get All Offers by authenicated user
     * 
     * @return Offer
     */
    public function index()
    {
        return Offer::where('user_id', auth()->id())
                    ->where('accepted_at', NULL)
                    ->with('tender')
                    ->get();
    }


    /**
     *  Create New Offer in DB
     * 
     * @param Tender
     * @param Request
     * 
     * @return Offer
     */
    public function store(Tender $tender, Request $request)
    { 
        $request->validate([
            'price' => [
                'required',
                'numeric',
                'gt:1',
                function ($attribute, $value, $fail) use ($tender){                                      
                    if ($value > $tender->max_price) {
                        $fail(__('The value is greater them tenders max. price.'));
                    }
                },
            ]
        ]);   
        
        if(intval($tender->user_id) === auth()->id()){
            return response()->json(['message' => 'Your can not make offers for own tender.'], 403);
        }

        if($tender->isActive){
            $offer = $tender->addOffer([
                'user_id' => auth()->id(),
                'price' => $request->price
            ]);             
            
            if($request->takeNow){ 
                return AcceptOfferJob::dispatch($offer); 
            }

            return $offer;
        }

        return response()->json(['message' => __('This Tender is no longer active.')], 403);        
    }

    /**
     * Accept Offer an place an Order
     * 
     * @param Offer
     * @return Order
    */
    public function update(Offer $offer)
    {        
        $this->authorize('show', $offer->tender);

        AcceptOfferJob::dispatch($offer);
    }

    /**
     *  Delete given offer in DB
     * 
     * @param Offer     
     */
    // public function destroy(Offer $offer)
    // {
    //     if($offer->user_id != auth()->id() || !empty($offer->order)){
    //         return response()->json(['message' => 'Your are not authorized to delete this offer.'], 403);
    //     }

    //     $offer->delete();
    // } 

}
