<?php

namespace Tests\Feature;

use Exception;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\InteractsWithStripe;

class StripePaymentTest extends PassportTestCase
{
    use RefreshDatabase, InteractsWithStripe;

    protected $company;
    protected $user;

    public function setUp():void
    {
        parent::setUp();

        $this->company = create('App\Company', [
            'stripe_id' => NULL,
            'card_brand' => NULL,
            'card_last_four' => NULL
        ]);

        $this->user = create('App\User', ['company_id' => $this->company->id]);
    }

    /** @test */
    function it_creates_new_payment_customer_and_update_card_data()
    { 
        $this->signIn($this->user);       

        $this->patchJson('api/payments/update', ['token' => $this->getStripeToken()]);

        $this->assertNotEmpty($this->company->fresh()->card_brand);
        $this->assertNotEmpty($this->company->fresh()->card_last_four);

        try {
            \Stripe\Customer::retrieve($this->company->fresh()->stripe_id);
        } catch (Exception $e) {
            $this->fail('No Stipe customer with the given ID.');
        }
    }

    /** @test */
    function it_creates_a_new_payment_subsscription_upon_new_payment_user_is_created()
    {  
        $this->signIn($this->user); 
        $this->assertEmpty($this->company->fresh()->paymentSubscription);   
        $this->patchJson('api/payments/update', ['token' => $this->getStripeToken()]);

        $this->assertNotEmpty($this->company->fresh()->paymentSubscription);

        try {
            \Stripe\Subscription::retrieve($this->company->paymentSubscription->stripe_id);
        } catch (Exception $e) {
            $this->fail('No Stipe Subscription with the given ID.');
        }
    }

    /** @test */
    function it_creates_new_subcsription_with_existing_company()
    {   
        $this->signIn($this->user);      
        $this->createStripeCustomer($this->company);
        $this->assertFalse($this->company->fresh()->hasPaymentSubscription); 

        $this->patchJson('api/payments/update', ['token' => $this->getStripeToken()]);

        $this->assertTrue($this->company->fresh()->hasPaymentSubscription); 
        
        try {
            \Stripe\Subscription::retrieve($this->company->paymentSubscription->stripe_id);
        } catch (Exception $e) {
            $this->fail('No Stipe Subscription with the given ID.');
        }
    }
    
    /** @test */
    function it_creates_an_new_invoice_in_DB_if_Stipe_invoice_is_finalized()
    {  
        $this->company->update(['stripe_id' => 'fake_ID']);

        $this->postJson('api/stripe/webhook', [
            'type' => 'invoice.finalized',
            'data' => [
                'object' => [
                    'id' => 'fake_stripe_id',
                    'number' => '1234',
                    'customer' => 'fake_ID',
                    'invoice_pdf' => 'some/pdf/link',
                    'hosted_invoice_url' => 'some/hosted/url'
                ]
            ]
        ]);
                    
        $this->assertCount(1, $this->company->invoices ); 
        $this->assertDatabaseHas('invoices', ['stripe_id' => 'fake_stripe_id']);
    }

    /** @test */
    function it_deletes_a_subscription_in_DB_if_stripe_subscription_is_canceled()
    {
        $subscription = create('App\PaymentSubscription',['company_id' => $this->company]);
        $this->assertNotEmpty($this->company->paymentSubscription);

        $this->postJson('api/stripe/webhook', [
            'type' => 'customer.subscription.deleted',
            'data' => [
                'object' => [
                    'id' => $subscription->stripe_id                   
                ]
            ]
        ]);        
        
        $this->assertEmpty($this->company->fresh()->paymentSubscription);
        $this->assertDatabaseMissing('payment_subscriptions', ['stripe_id' => $subscription->stripe_id ]);        
    }

    /** @test */
    function a_user_may_fetch_all_his_invoices()
    {
        $user = create('App\User');       
        create('App\Invoice', ['company_id' => $user->company->id], 2);         
        
        $this->signIn($user);
        
        $response = $this->getJson('api/payments/invoices')->json();
       
        $this->assertCount(2, $response);
    }


  
}