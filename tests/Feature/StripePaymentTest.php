<?php

namespace Tests\Feature;

use Exception;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\InteractsWithStripe;

class StripePaymentTest extends PassportTestCase
{
    use RefreshDatabase, InteractsWithStripe;

    /** @test */
    function it_creates_new_payment_customer_and_update_card_data()
    {
        $company = create('App\Company', [
            'stripe_id' => NULL,
            'card_brand' => NULL,
            'card_last_four' => NULL
        ]);
        $user = create('App\User', ['company_id' => $company->id]);

        $this->assertFalse($company->paymentCustomer);

        $this->signIn($user);       

        $this->patchJson('api/payments/update', ['token' => $this->getStripeToken()]);

        $this->assertTrue($company->fresh()->paymentCustomer);
        $this->assertNotEmpty($company->fresh()->card_brand);
        $this->assertNotEmpty($company->fresh()->card_last_four);

        try {
            \Stripe\Customer::retrieve($company->fresh()->stripe_id);
        } catch (Exception $e) {
            $this->fail('No Stipe customer with the given ID.');
        }
    }
    
    /** @test */
    function it_adds_a_pfd_link_to_the_existing_invoice_if_invoice_is_finalized()
    {
        $invoice = create('App\Invoice', [
            'stripe_id' => 'fake_stripe_id'
        ]);

        $this->postJson('api/stripe/webhook', [
            'type' => 'invoice.finalized',
            'data' => [
                'object' => [
                    'id' => 'fake_stripe_id',
                    'invoice_pdf' => 'some/pdf/link',
                    'hosted_invoice_url' => 'some/hosted/url'
                ]
            ]
        ]);

        $this->assertNotEmpty($invoice->fresh()->pdf_url);
        $this->assertNotEmpty($invoice->fresh()->hosted_url);
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