<?php

namespace App\Listeners;

use App\Events\OfferAccepted;
use App\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateOrder
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
        return Order::create([
            'tender_id' => $event->offer->tender->id,
            'offer_id' => $event->offer->id,
            'carrier_id' => $event->offer->user_id,
            'tenderer_id' => $event->offer->tender->user_id
        ]); 
    }
}
