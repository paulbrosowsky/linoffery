<?php


namespace Tests\Feature\Console;

use Tests\PassportTestCase;
use Tests\Traits\InteractsWithStripe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;

class CreateInvoicesCommandTest extends PassportTestCase
{
    use RefreshDatabase, InteractsWithStripe;
    
    /** @test */
    function it_creates_monthly_invoices()
    {        
        $company = create('App\Company', ['stripe_id' => NULL]);
        $user = create('App\User', ['company_id' => $company->id]); 
        $order = create('App\Order', [
            'carrier_id' => $user->id,                     
        ]);    
        
        $this->createStripeCustomer($company);

        $this->assertEmpty($company->invoices);

        $this->artisan('linoffery:create-invoices');
        
        // Creates Invoice in DB ?
        $this->assertCount(1, $company->fresh()->invoices);

        // Is Order set as billed?
        $this->assertNotEmpty($order->fresh()->billed_at);
        
        // Creates Invioce on Strive server?
        try {
            \Stripe\Invoice::retrieve($company->fresh()->invoices[0]->stripe_id);
        } catch (Exception $e) {
            $this->fail('No Stripe invoice with the given ID.');
        }       
    }
    
}