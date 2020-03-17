<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CompleteTender
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
    public function handle(OrderCreated $event)
    {        
        $event->order->tender->complete();
    }
}
