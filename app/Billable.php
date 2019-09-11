<?php

namespace App;

use Illuminate\Support\Facades\App;
use Stripe\Customer;
use Stripe\InvoiceItem;
use Stripe\Invoice as StripeInvoice;

trait Billable{

     /**
     *  Add Stripe Customer an add default payment data
     * 
     * @param array $token
     */
    public function addAsStripeCustomer($token)
    {        
        $customer = Customer::create([
            'email' => $this->user->email,
            'name'  => $this->name,
            'description' => $this->custom_id,
            'address' => [
                'line1' => $this->address,
                'city' => $this->city,
                'postal_code' => $this->postcode,
                'country' => $this->country
            ],
            'preferred_locales' => [ App::getLocale() ],
            'source' => $token['id']
        ]);  
        
        $this->update([
            'stripe_id' => $customer->id,
            'customer_created_at' => now(),
            'card_brand' => $token['card']['brand'],
            'card_last_four' => $token['card']['last4']
        ]); 
    }

    /**
     *  Update Companies default payment method
     * 
     * @param array $token
     */
    public function updatePaymentMethod($token)
    {     
        Customer::update($this->stripe_id, [
            'source' => $token['id']
        ]);
            
        $this->update([            
            'card_brand' => $token['card']['brand'],
            'card_last_four' => $token['card']['last4']
        ]);
    }
    
    /**
     *  Create Stipe Invoice
     * 
     * @param Order $orders
     */
    public function createInvoice($orders)
    {  
        $this->createInvoiceItems($orders);

        $invoice = StripeInvoice::create([
            'customer' => $this->stripe_id,
            'auto_advance' => true,                     
        ]);

        Invoice::create([
            'company_id' => $this->id,
            'custom_id' => $invoice->number,
            'stripe_id' => $invoice->id,
            'pdf_url' => $invoice->invoice_pdf,
            'hosted_url' => $invoice->hosted_invoice_url 
        ]);        
    }

    /**
     *  Create Stripe Invoice Items 
     * 
     *  @param Order $orders
     */
    public function createInvoiceItems($orders)
    {
        $orders->each(function($order){ 
            $offer = \App\Offer::where('id', $order->offer_id)->get();            
            InvoiceItem::create([
                'customer' => $this->stripe_id,                
                'amount' => $order->cost * 100, // in € Cent
                'currency' => 'eur',
                'description' => $order->custom_id .' vom '. $order->created_at->format('d.m.Y'), 
            ]);

            $order->markAsBilled();
        });       
    } 

    /**
     *  A Company has many invoices
     * 
     * @return hasMany
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
}