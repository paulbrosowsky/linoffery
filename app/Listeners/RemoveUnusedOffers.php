<?php

namespace App\Listeners;


use App\Events\TenderCompleted;
use App\Notifications\TenderIsCompleted;
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
     * @param  TenderCompleted  $event
     * @return void
     */
    public function handle(TenderCompleted $event)
    {
        $offers = $event->tender->offers->where('accepted_at', NULL);

        $offers->each(function($offer){
            $offer->delete();
        });      
        
    }
}
