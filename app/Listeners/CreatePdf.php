<?php

namespace App\Listeners;

use App\Events\PaymentCreated;
use App\Events\OrderCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePdf implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }    

    /**
     * Handle the Order Created Event.
     *
     * @param  OrderCreated  $event
     * @return void
     */
    public function handleOrderCreated(OrderCreated $event)
    {   
        return $event->order->makePdf();
    }

    /**
     * Handle the Invoice Created Event.
     *
     * @param  PaymentCreated  $event
     * @return void
     */
    public function handlePaymentCreated(PaymentCreated $event)
    {   
        $path = $event->invoice->createPdf('pdf.invoice', [
            'receiver' => $event->invoice->order->tenderer->company,
            'invoice' => $event->invoice 
        ]);        
            
        $event->invoice->update([ 'pdf_url' => $path ]);

        return $path;
    }

     /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {    
        $events->listen(
            OrderCreated::class,            
            'App\Listeners\CreatePdf@handleOrderCreated'
        );  
        
        $events->listen(
            PaymentCreated::class,            
            'App\Listeners\CreatePdf@handlePaymentCreated'
        );
    }
}
