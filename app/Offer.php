<?php

namespace App;

use App\Notifications\OfferWasAccepted;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{  
    use HasCustomId;

    protected $guarded = [];

    protected $with = ['user']; 

    /**
     * A Offer belong to a user
     * 
     * @return belondsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::created(function($offer){
            $offer->tender->updateLowestOffer();            
        });  

        static::deleted(function($offer){
            $offer->tender->updateLowestOffer();            
        });  
    }

    /**
     * A Offer belong to a tender
     * 
     * @return belondsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

     /**
     * A Offer has one order
     * 
     * @return hasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    /**
     *  Set an order as accepted 
     * 
     * @return Order
     */
    public function accept()
    {        
        $this->update(['accepted_at' => Carbon::now()]);
        $this->tender->complete(); 

        $order = $this->makeOrder();
        
        $this->user->notify(new OfferWasAccepted($order, $this));
        $this->tender->user->notify(new OfferWasAccepted($order, $this));

        return $order;
    }

    /**
     *  Make a new Order
     * 
     * @return Order
     */
    protected function makeOrder()
    {
        $order =  Order::create([
            'tender_id' => $this->tender->id,
            'offer_id' => $this->id,
            'carrier_id' => $this->user_id,
            'tenderer_id' => $this->tender->user_id
        ]); 

        $order->makePdf();

        // $this->user->company->createCharge($this->price);
        // $this->user->company->createInvoice($this->price);

        // $this->user->company->updateUsageRecord($this->price);
        
        return $order;
    }
}
