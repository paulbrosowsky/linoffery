<?php

namespace App\Listeners;

use App\Events\OfferAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveUnusedOffers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OfferAccepted  $event
     * @return void
     */
    public function handle(OfferAccepted $event)
    {        
        $offers = $event->offer->tender->offers->where('accepted_at', NULL);

        $offers->each(function($offer){
            $offer->delete();
        });      
        
    }
}
