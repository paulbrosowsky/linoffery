<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Invoice;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateInvoice implements ShouldQueue
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
     * @param  OrderCreated  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {        
        Invoice::create([
            'company_id' => $event->order->tenderer->company->id,
            'order_id' => $event->order->id, 
            'custom_id' => '',                     
        ]);        
    }
}
