<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Events\TenderCloned;
use App\Events\TenderCompleted;
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
     * @param  TenderCompleted $event
     * @return void
     */
    public function handleTenderCompleted(TenderCompleted $event)
    {        
        $users = $event->tender->offers
                    ->where('accepted_at', NULL)                    
                    ->pluck('user');
        
        if(isset($users)){
            $users->unique()->each(function($user) use ($event){
                $user->notify(new TenderIsCompleted($event->tender));
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
            TenderCompleted::class,            
            'App\Listeners\NotifyTenderOfferer@handleTenderCompleted'
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
