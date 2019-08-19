<?php

namespace App\Http\Controllers;

use App\Tender;
use Illuminate\Http\Request;
use App\Offer;
use App\Order;

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
        $maxPrice = $tender->max_price;

        $request->validate([
            'price' => [
                'required',
                'numeric',
                'gt:1',
                function ($attribute, $value, $fail) use ($maxPrice){                                      
                    if ($value > $maxPrice) {
                        $fail(__('The value is greater them tenders max. price.'));
                    }
                },
            ]
        ]);   
        
        if(intval($tender->user_id) === auth()->id()){
            return response()->json(['message' => 'Your can not make offers for own tender.'], 403);
        }
        
        $offer = Offer::create([
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
            'price' => $request->price
        ]);
        
        if($request->takeNow){
            $this->acceptOffer($offer);
        }

        return $offer;
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

        $order = $this->acceptOffer($offer);

        return $order;
    }

    /**
     *  Delete given offer in DB
     * 
     * @param Offer     
     */
    public function destroy(Offer $offer)
    {
        if($offer->user_id != auth()->id()){
            return response()->json(['message' => 'Your are not authorized to delete this offer.'], 403);
        }

        $offer->delete();
    }

    /**
     * Update Offer As accepted and create Order
     * 
     * @param Offer
     * @return Order
     */   
    protected function acceptOffer($offer)
    {        
        $offer->accept();        
        $offer->tender->complete();             

        $order= Order::create([
            'tender_id' => $offer->tender->id,
            'offer_id' => $offer->id,
            'carrier_id' => $offer->user_id,
            'tenderer_id' => $offer->tender->user_id
        ]);       
            
        return $order;
    }

}
