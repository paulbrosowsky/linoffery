<?php

namespace App;

use Carbon\Carbon;
use App\Filters\TenderFilters;
use App\Notifications\OfferWasCreated;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\OfferWasOutbidded;
use App\Notifications\TenderIsCompleted;

class Tender extends Model
{
    protected $guarded = [];

    protected $with = [ 'user', 'locations', 'freights', 'category'];

    protected $appends = ['offersCount', 'isActive'];

    /**
     * A Tender belong to user
     * 
     * @return belondsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A Tender belong to a category
     * 
     * @return belondsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * A Tender has many Locations
     * 
     * @return hasMany
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

     /**
     * A Tender has many Freights
     * 
     * @return hasMany
     */
    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    /**
     * A Tender has many Offers
     * 
     * @return hasMany
     */
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    /**
     *  Check if current User owns a tender
     */
    public function owner()
    {        
        return intval($this->user_id) === auth('api')->id();
    }

    /**
    *  Update lowest offer in DB    
    */
    public function updateLowestOffer()
    {  
        $price = $this->offers()->min('price');
        
        $this->update(['lowest_offer' => $price]);       
    }

     /**
    *  Update weight in DB    
    */
    public function updateWeight()
    {  
        $weight = $this->freights->sum('weight');             
        $this->update(['weight' => $weight]);       
    }

    /**
    *  Get Offers Counter
    * @return nummeric
    */
    public function getOffersCountAttribute()
    {
        return $this->offers()->count();
    }

    /**
     * Set Tender as completed
     */
    public function complete()
    {      
        $this->update(['completed_at' => Carbon::now()]);
        $this->removeUnacceptedOffers();
    }
    
    /**
     * Delete all unaccepted offers
     */
    protected function removeUnacceptedOffers()
    {   
        $offers = $this->offers->where('accepted_at', NULL);
        $users = collect(); 

        $offers->each(function($offer) use ($users) {
            $users = $users->push($offer->user);            
            $offer->delete();
        });
        
        $users->unique()->each(function($user){
            $user->notify(new TenderIsCompleted($this));
        });       
    }

    /**
     *  Check if Tender still Active
     * 
     * @return boolean
    */
    public function getIsActiveAttribute()
    {
        return isset($this->published_at) && !isset($this->completed_at) ;
    }

    /**
     * Apply all relevant Tender filters.
     *
     * @param  Builder       $query
     * @param  TenderFilters $filters
     * @return Builder
    */
    public function scopeFilter($query, TenderFilters $filters)
    {        
        return $filters->apply($query);
    }

    /**
     *  Add new Offer to a given tender
     * 
     * @param array $offer
     * @return Offer
     */
    public function addOffer($offer)
    {   
        $this->notifyOutbiddedUsers($offer);        
        
        $offer = $this->offers()->create($offer); 

        $this->notifyTendersOwner($offer);

        return $offer;
    }

    /**
     *  Notify Tender owner about new offer
     * @param Offer
     */
    protected function notifyTendersOwner($offer)
    {
        $this->user->notify(new OfferWasCreated($this, $offer));                  
    }

    /**
     *  Notify outbidded offer owners
     * @param array
     */
    protected function notifyOutbiddedUsers($offer)
    {        
        $lowestOffer = $this->offers()->where('price', $this->offers()->min('price'))->first();
      
        if($lowestOffer && $lowestOffer->price > $offer['price']){
            $lowestOffer->user->notify(new OfferWasOutbidded($this, $offer));
        }
    }


}
