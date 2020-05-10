<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\TenderCloned;
use App\Events\OfferAccepted;
use App\Notifications\OfferWasAccepted;
use App\Notifications\TenderIsCompleted;
use App\Notifications\TenderWasCloned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyTenderOfferer
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
     * Handle the OrderCreated event.
     *
     * @param  OfferAccepted $event
     * @return void
     */
    public function handleOfferAccepted(OfferAccepted $event)
    {        
        $users = $event->offer->tender->offers
                    ->where('accepted_at', NULL)                    
                    ->pluck('user');
        
        if(isset($users)){
            $users->unique()->each(function($user) use ($event){
                $user->notify(new TenderIsCompleted($event->offer->tender));
            });  
        }
    }

    /**
     * Handle the OrderCreated Event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handleOrderCreated(OrderCreated $event)
    {        
        $event->order->carrier
            ->notify( (new OfferWasAccepted($event->order))->delay(now()->addSeconds(10)) ); 
    }   

      /**
     * Handle the TenderCloned Event.
     *
     * @param  TenderCloned  $event
     * @return void
     */
    public function handleTenderCloned(TenderCloned $event)
    {           
        $users = $event->original->offers
                    ->where('accepted_at', NULL)                    
                    ->pluck('user');  
        
        
        if(isset($users)){            
            $users->unique()->each(function($user) use ($event){
                          
                if(env('APP_ENV') === 'testing'){                    
                    $user->notify((new TenderWasCloned($event->clone)));
                }else{
                    $user->notify((new TenderWasCloned($event->clone))->delay(now()->addHours(1)));
                }               
            });  
        } 
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {        
        $events->listen(
            OfferAccepted::class,            
            'App\Listeners\NotifyTenderOfferer@handleOfferAccepted'
        );

        $events->listen(
            OrderCreated::class,            
            'App\Listeners\NotifyTenderOfferer@handleOrderCreated'
        );  
        
        $events->listen(
            TenderCloned::class,            
            'App\Listeners\NotifyTenderOfferer@handleTenderCloned'
        ); 
    }
}
