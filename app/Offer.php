<?php

namespace App;

use App\Events\OrderCreated;
use App\Notifications\OfferWasAccepted;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{  
    use HasCustomId;

    protected $guarded = [];

    protected $with = ['user'];   

    protected $append = ['active'];

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
     * A Offer belong to a user
     * 
     * @return belondsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
     *  Destroy existing Offer
     * 
     */
    public function destroyOffer()
    {
        if(!empty($this->order)){
            return 'Delete not alowed.';
        }        
        $this->delete();
    }

    public function getActiveAttribute()
    {
        return $this->tender->isActive;
    }
}
