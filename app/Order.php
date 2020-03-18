<?php

namespace App;

use App\Events\OrderCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasCustomId, HasPdf;
    
    protected $guarded = [];

    protected $with = ['tenderer', 'carrier', 'offer'];

    protected $appends = ['cost'];  
    
    protected static function boot(){

        parent::boot();

        static::created(function($order){
            OrderCreated::dispatch($order); 
        });
    }

    /**
     * A Order belong to a tenderer
     * 
     * @return belondsTo
     */
    public function tenderer()
    {
        return $this->belongsTo(User::class, 'tenderer_id')->withTrashed();
    }

    /**
     * A Order belong to a carrier
     * 
     * @return belondsTo
     */
    public function carrier()
    {
        return $this->belongsTo(User::class, 'carrier_id')->withTrashed();
    }

    /**
     * A Order belong to a tender
     * 
     * @return belondsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * A Order belong to an offer
     * 
     * @return belondsTo
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    /**
     *  An order has one Invoice
     * 
     * @return hasOne
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     *  Get calculated service cost of an order
     * 
     * @return float
     */
    public function getCostAttribute()
    {           
        // price in euro * (sevice fee in % * / 100%)  
        $cost = $this->offer->price * (config('linoffery.payment.standard')/100);  

        return number_format($cost, 2);
    }    

    /**
     *  Make Order as PDF ans save them in the storage     
     */
    public function makePdf()
    {      
        $pickup = $this->tender->locations->where('type', 'pickup')->first();
        $delivery = $this->tender->locations->where('type', 'delivery')->first();  
       
        // Make PDF For Shipper
        $shipperPdf =$this->createPdf('pdf.order', [
            'order' => $this,            
            'pickup' => $pickup,
            'delivery' => $delivery, 
            'receiver' => $this->tenderer->company         
        ], 'shipper'); 
        // Make PDF For Carrier
        $carrierPdf = $this->createPdf('pdf.order', [
            'order' => $this,            
            'pickup' => $pickup,
            'delivery' => $delivery,            
            'receiver' => $this->carrier->company
        ], 'carrier'); 

        return isset($shipperPdf) && isset($carrierPdf);
    }

    // /**
    //  *  Mark Order as billable when invoice was created    
    //  */
    // public function markAsBilled()
    // {
    //     $this->update(['billed_at' => now()]);
    // }
}
