<?php

namespace App;

use Illuminate\Support\Facades\App;
use Stripe\Customer;
use Stripe\InvoiceItem;
use Stripe\Invoice as StripeInvoice;
use Stripe\Subscription;

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
        $orders->each(function($order){
            $this->createInvoiceItem($order);
        });        

        StripeInvoice::create([
            'customer' => $this->stripe_id,
            'auto_advance' => true,                     
        ]);               
    }

    /**
     *  Create Stripe Invoice Items 
     * 
     *  @param Order $orders
     */
    public function createInvoiceItem($order)
    {                      
        InvoiceItem::create([
            'customer' => $this->stripe_id,                
            'amount' => $order->cost * 100, // in € Cent
            'currency' => 'eur',
            'description' => $order->custom_id .' vom '. $order->created_at->format('d.m.Y'), 
        ]);

        $order->markAsBilled();             
    } 

    /**
     *  Create Stipe Subscription + Payment Subscription in DB
     */
    public function createPaymentSubscription()
    {      
        $subscription = Subscription::create([
            "customer" => $this->stripe_id,
            "items" => [
                [
                    "plan" => "main"
                ],
            ],                
        ]);
        
        $this->paymentSubscription()->create([
            "stripe_id" => $subscription->id,
            "plan" => $subscription->plan->id
        ]);
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

    /**
     *  A Company has one payment subscriptions
     * 
     * @return hasOne
     */
    public function paymentSubscription()
    {
        return $this->hasOne(PaymentSubscription::class);
    }
    
    /**
     *  Delete a Stripe Customer      * 
     */
    public function deleteStipeCustomer()
    {
        if($this->stripe_id){
            $customer = Customer::retrieve($this->stripe_id);
            $customer->delete();
        }

        if (env('APP_ENV')==='testing') {
            return;
        }

        $this->update([
            'stripe_id' => NULL,
            'card_last_four' => NULL,
            'card_brand' => NULL,
        ]);
       
    }
    
}