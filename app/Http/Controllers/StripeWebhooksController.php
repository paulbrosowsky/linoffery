<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use App\PaymentSubscription;
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
        $invoice = $payload['data']['object'];
        $company = Company::where('stripe_id', $invoice['customer'])->first();
        
        Invoice::create([
            'company_id' => $company->id,
            'custom_id' => $invoice['number'],
            'stripe_id' => $invoice['id'],
            'pdf_url' => $invoice['invoice_pdf'],
            'hosted_url' => $invoice['hosted_invoice_url'] 
        ]); 
    }

    /** 
     *  Handel when subscription is deleted
     * 
     * @param array $payload
     * 
    */
    public function whenCustomerSubscriptionDeleted($payload)
    {
        $subscription = $payload['data']['object'];
        
        PaymentSubscription::where('stripe_id', $subscription['id'])->delete(); 
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
