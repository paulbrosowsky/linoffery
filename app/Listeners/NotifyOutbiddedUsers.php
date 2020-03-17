<?php

namespace App\Listeners;

use App\Events\OfferCreated;
use App\Notifications\OfferWasOutbidded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyOutbiddedUsers
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
     * @param  OfferCreated  $event
     * @return void
     */
    public function handle(OfferCreated $event)
    {        
        // Find min offer before current one
        $prevMinPrice = $event->tender->offers()
                        ->where('price', '>', $event->offer->price)
                        ->get()
                        ->min('price');         
        $bestOffer = $event->tender->offers()
                        ->where('price', $prevMinPrice)
                        ->first(); 
        
        // Notify Uses with previous best Offer 
        if( 
            isset($bestOffer) &&
            $bestOffer->price > $event->offer->price && 
            $bestOffer->user_id != $event->offer->user_id
        ){            
            $bestOffer->user->notify(new OfferWasOutbidded($event->tender, $event->offer));
        }
    }
}
