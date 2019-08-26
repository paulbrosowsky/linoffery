<?php

namespace App;

use App\Filters\TenderFilters;
use App\Notifications\OfferWasCreated;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
        $this->offers
            ->where('accepted_at', NULL)
            ->each(function($offer){
                $offer->delete();
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
        $offer = $this->offers()->create($offer);

        $this->notifyUser($offer);

        return $offer;
    }

    /**
     *  Notify Tender owner abot new offer
     * @param Offer
     */
    public function notifyUser($offer)
    {
        $this->user->notify(new OfferWasCreated($this, $offer));        
    }


}
