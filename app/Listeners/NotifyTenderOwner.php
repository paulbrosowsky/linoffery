<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use App\Events\OfferCreated;
use App\Events\OrderCreated;
use App\Mail\PayInvoiceEmail;
use App\Notifications\OfferWasAccepted;
use App\Notifications\OfferWasCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyTenderOwner
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
     * Handle the OfferCreated Event.
     *
     * @param  OfferCreated  $event
     * @return void
     */
    public function handleOfferCreated(OfferCreated $event)
    {        
        $event->tender->user->notify(new OfferWasCreated($event->tender, $event->offer));       
    }

    /**
     * Handle the OrderCreated Event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handleOrderCreated(OrderCreated $event)
    {             
        $event->order->tenderer
            ->notify(
                ( new OfferWasAccepted($event->order) )
                ->delay(now()->addSeconds(10))
            );        
    }

      /**
     * Handle the Payment Created Event.
     *
     * @param  PaymentCreated  $event
     * @return void
     */
    public function handlePaymentCreated(PaymentCreated $event)
    {         
        $when = now()->addSeconds(10);

        Mail::to($event->invoice->order->tenderer)->later($when, new PayInvoiceEmail($event->invoice) );
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {   
        $events->listen(
            OfferCreated::class,            
            'App\Listeners\NotifyTenderOwner@handleOfferCreated'
        );

        $events->listen(
            OrderCreated::class,            
            'App\Listeners\NotifyTenderOwner@handleOrderCreated'
        );  

        $events->listen(
            PaymentCreated::class,            
            'App\Listeners\NotifyTenderOwner@handlePaymentCreated'
        );         
        
    }


}
