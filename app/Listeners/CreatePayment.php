<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Events\PaymentCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mollie\Laravel\Facades\Mollie;

class CreatePayment implements ShouldQueue
{
    /**de
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
     * @param  InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
    {
        if(env('APP_ENV') != 'production'){
            $webhookUrl = env('MOLLIE_WEBHOOK');            
        }else{
            $webhookUrl = route('mollie.webhook');          
        }  
        
        $value = $this->getValue($event->invoice); 

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $value
            ],                                    
            'description' => __('Order') .': '. $event->invoice->order->custom_id.' / '.__('Invoice') .': '. $event->invoice->custom_id,
            'webhookUrl' => $webhookUrl,
            'redirectUrl' => config('app.url') .'/orders/'. $event->invoice->order->id ,
        ]);  
        
        $payment = Mollie::api()->payments()->get($payment->id); 

        $event->invoice->update([
            'payment_id' => $payment->id,
            'payment_link' => $payment->getCheckoutUrl(),
            'status' => 'open'
        ]);  
        
        PaymentCreated::dispatch($event->invoice);
    }

    /**
     * Determine whether the listener should be queued.
     *
     * @param  \App\Events\InvoiceCrated $event
     * @return bool
     */
    public function shouldQueue(InvoiceCreated $event)
    {        
        return env('APP_ENV') != 'testing' || $event->testable;
    }

    protected function getValue($invoice)
    {   
        if($invoice->company->deLocated){
            return number_format($invoice->order->cost * 1.19, 2);
        }
        return $invoice->order->cost;
    }

}
