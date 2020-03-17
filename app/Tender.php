<?php

namespace App;

use App\Events\OfferCreated;
use App\Events\TenderCompleted;
use Carbon\Carbon;
use App\Filters\TenderFilters;
use App\Notifications\OfferWasCreated;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\OfferWasOutbidded;
use App\Notifications\TenderIsCompleted;
use App\Notifications\TenderWasCloned;

class Tender extends Model
{
    use HasCustomId;

    protected $guarded = [];

    protected $with = [ 'user', 'locations', 'freights', 'category'];

    protected $appends = ['offersCount', 'isActive', 'orderId']; 



    protected static function boot()
    {
        parent::boot(); 

        static::deleted(function($tender){
            $tender->locations()->each(function($location){
                $location->delete();
            });  
            
            $tender->freights()->each(function($freight){
                $freight->delete();
            }); 
        });  
       
    }

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
     * A Offer has one order
     * 
     * @return hasOne
     */
    public function order()
    {
        return $this->hasOne(Order::class);
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
     *  Check if Tender still Active
     * 
     * @return boolean
    */
    public function getIsActiveAttribute()
    {
        return isset($this->published_at) && !isset($this->completed_at) ;
    }

    /**
     *  Check if Tender still Active
     * 
     * @return boolean
    */
    public function getOrderIdAttribute()
    {
        return $this->order ? $this->order->id : NULL;
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

        OfferCreated::dispatch($this, $offer);  

        return $offer;
    }   
    

    /**
     * Set Tender as completed
     */
    public function complete($withClone = null)
    {      
        $this->update(['completed_at' => now()]);

        TenderCompleted::dispatch($this);

        

        // if($withClone){
        //     $this->cloneTender($offerers);            
        // }
    }   

    /**
     * Clone Tender and Delete Original
     * 
     * @param Collection $offers
     * @return Tender
     */
    public function cloneTender($offerers = NULL)
    {   
        $clone = $this->replicate(['published_at', 'completed_at', 'lowest_offer']); 
        $clone->save();
      
        // Clone all locations from original and attach it to the tender clone
        foreach ($this->locations as $location) {
            $location->update(['tender_id' => $clone->id]);
        }
        // Clone all freights from original and attach it to the tender clone
        foreach ($this->freights as $freight) {            
            $freight->update(['tender_id' => $clone->id]);
        }     
        
        //Delete orginal
        $this->delete();

        if($offerers){
            //Notify all offerers
            $later = now()->addHours(1);
            foreach ($offerers as $offerer) {
                if(env('APP_ENV') === 'testing'){
                    $offerer->notify((new TenderWasCloned($clone)));
                }else{
                    $offerer->notify((new TenderWasCloned($clone))->delay($later));
                }            
            }  
        }             

        return $clone;                        
    }

    /**
     *  Destroy existing tender 
     */
    public function destroyTender()
    {
        if(!empty($this->order)){
            return 'Delete not alowed.';
        }
        $this->complete();
        $this->delete();
    }
}
