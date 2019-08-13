<?php

namespace App\Http\Controllers;

use App\Tender;
use Illuminate\Http\Request;
use App\Offer;

class OffersController extends Controller
{
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
        
        $userId = $tender->user_id;        
        gettype($userId) === 'string' ? $userId = intval($userId) : '';        
        
        if($userId === auth()->id()){
            return response()->json(['message' => 'Your can not make offers for own tender.'], 403);
        }
        
        $offer = Offer::create([
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
            'price' => $request->price
        ]);

        return $offer;
    }

    public function destroy(Offer $offer)
    {
        if($offer->user_id != auth()->id()){
            return response()->json(['message' => 'Your are not authorized to delete this offer.'], 403);
        }

        $offer->delete();
    }
}
