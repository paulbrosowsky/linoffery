<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $with = ['tenderer', 'carrier', 'offer', 'tender'];

     /**
     * A Order belong to a tenderer
     * 
     * @return belondsTo
     */
    public function tenderer()
    {
        return $this->belongsTo(User::class, 'tenderer_id');
    }

    /**
     * A Order belong to a carrier
     * 
     * @return belondsTo
     */
    public function carrier()
    {
        return $this->belongsTo(User::class, 'carrier_id');
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
}
