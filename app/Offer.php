<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{  
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
     */
    public function accept()
    {
        $this->update(['accepted_at' => Carbon::now()]);
    }
}
