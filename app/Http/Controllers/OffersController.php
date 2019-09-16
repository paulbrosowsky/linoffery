<?php

namespace App\Http\Controllers;

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
        
        $offer = $tender->addOffer([
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
            'price' => $request->price
        ]);         
        
        if($request->takeNow){
            return $offer->accept();            
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

        $order = $offer->accept();

        return $order;
    }

    /**
     *  Delete given offer in DB
     * 
     * @param Offer     
     */
    public function destroy(Offer $offer)
    {
        if($offer->user_id != auth()->id() || !empty($offer->order)){
            return response()->json(['message' => 'Your are not authorized to delete this offer.'], 403);
        }

        $offer->delete();
    } 

}
