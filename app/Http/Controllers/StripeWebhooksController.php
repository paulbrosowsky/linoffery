<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class StripeWebhooksController extends Controller
{
    /**
     *  Handle Stripe Webhooks
     * 
     * @return response
     */
    public function handle()
    { 
        $payload = request()->all();

        $method = $this->eventToMethod($payload['type']);

        if (method_exists($this, $method)) {
            $this->$method($payload);
        }

        return response('Webhooks Received');
    }

    /** 
     *  Handel when invoice is finalized
     * 
     * @param array $payload
     * 
    */
    public function whenInvoiceFinalized($payload)
    {        
        $invoice = Invoice::where('stripe_id', $payload['data']['object']['id'])->first();        

        $invoice->addPdf($payload['data']['object']);
    }

    /**
     *  Transform event to a method
     * 
     * @param string $event
     * @return string
     */
    protected function eventToMethod($event)
    {
        return 'when' . studly_case(str_replace('.', '_', $event));
    }
}
