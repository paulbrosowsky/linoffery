<?php

namespace Tests\Feature;

use App\Company;
use App\User;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\InteractsWithStripe;

class DeleteAccountTest extends PassportTestCase
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
    function users_may_delete_thier_accounts()
    { 
        $this->signIn($this->user);

        $this->deleteJson('api/auth/destroy');

        $this->assertEmpty(User::all());
        $this->assertNotEmpty($this->user->fresh()->deleted_at);
        $this->assertEmpty(Company::all());
        $this->assertNotEmpty($this->user->company->fresh()->deleted_at);
    }

    /** @test */
    function users_tender_offers_and_comments_will_be_deleted_if_account_is_canceled()
    {        
        $tender = create('App\Tender', ['user_id'=> $this->user->id]);
        $offer = create('App\Offer', ['user_id'=> $this->user->id]);
        $comment = create('App\Comment', ['user_id'=> $this->user->id]);

        $this->user->delete();

        $this->assertDatabaseMissing('tenders', ['id' => $tender->id]);
        $this->assertDatabaseMissing('offers', ['id' => $offer->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    /** @test */
    function offers_and_tenders_can_not_be_deleted_if_they_conected_to_an_order()
    {        
        $tender = create('App\Tender', ['user_id'=> $this->user->id]);
        $offer = create('App\Offer', ['user_id'=> $this->user->id]);
        $order = create('App\Order', [
            'offer_id' => $offer->id,
            'tender_id' => $tender->id
        ]);

        $this->user->delete();

        $this->assertDatabaseHas('tenders', ['id' => $tender->id]);
        $this->assertDatabaseHas('offers', ['id' => $offer->id]);       
    }

    /** @test */
    function orders_can_view_user_and_company_data_althought_they_are_deleted()
    {        
        $order = create('App\Order', [
            'carrier_id' => $this->user->id,
        ]);

        $this->user->delete();

        $this->assertNotEmpty($order->carrier);    
        $this->assertNotEmpty($order->carrier->company); 
    }

    /** @test */
    function payment_subcription_will_be_deleted_upon_deleting_account()
    {  
        $this->createStripeCustomer($this->company);

        $this->user->delete();

        $response = \Stripe\Customer::retrieve($this->company->fresh()->stripe_id);
        $this->assertTrue($response['deleted']);        
    }
    

}