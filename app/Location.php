<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{

    protected $guarded = [];

    /**
     *  A Location belongs to a Tender
     * 
     * @return belongsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * Get Earliest Date Attribute
     * 
     * @param string $date
     * @return Carbon
     */
    public function getEarliestDateAttribute($date)
    {
        return new Carbon($date);
    }

    /**
     * Get latest Date Attribute
     * 
     * @param string $date
     * @return Carbon
     */
    public function getLatestDateAttribute($date)
    {
        return new Carbon($date);
    }

    public function getLoadingAttribute($loading)
    {
        return $loading ? __('Yes') : __('No');
    }
}
