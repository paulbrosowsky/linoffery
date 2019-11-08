<?php


namespace Tests\Feature;

use App\Order;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MakeOfferTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $tender;
    protected $user;
    
    public function setUp():void
    {
        parent::setup();

        $this->withExceptionHandling();

        $this->tender = create('App\Tender');
        $this->user = create('App\User');
    }

     /** @test */
    function guests_may_not_make_offers()
    {   
        $this->postJson('api/tenders/1/offers/store')
            ->assertStatus(401);            
    }


    /** @test */
    function authorized_users_may_make_offers()
    {
        $this->makeOffer();      
        
        $this->assertCount(1, $this->tender->offers);  
        $this->assertDatabaseHas('offers', ['price' => 100]);        
    }

    /** @test */
    function a_user_must_confirm_his_email_address_to_make_offer()
    {
        $this->user->update(['confirmed' => false]);

        $this->makeOffer()->assertStatus(401);        
    }

     /** @test */
    function a_users_company_must_have_valid_address_to_make_offer()
    { 
        $this->user->company->update(['address' => null]);  
             
        $this->makeOffer()->assertStatus(401);        
    }

    // /** @test */
    // function a_users_maus_have_payment_informations_to_make_offer()
    // { 
    //     $this->user->company->update(['stripe_id' => null]);  
             
    //     $this->makeOffer()->assertStatus(401);        
    // }

    /** @test */
    function tender_owners_may_not_make_offers()
    {
        $this->tender->update(['user_id' => $this->user->id]);

        $this->makeOffer()->assertStatus(403);
    }

    /** @test */
    function users_may_not_make_offer_at_not_active_tender()
    {
        $this->tender->update(['completed_at' => now()]);

        $this->makeOffer()->assertStatus(403);
    }

     /** @test */
    function price_is_required()
    {
        $response = $this->makeOffer([            
            'price' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('price', $errors['errors']);           
    } 

    /** @test */
    function price_is_numeric()
    {
        $response = $this->makeOffer([            
            'price' => 'wew' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('price', $errors['errors']);           
    } 

    /** @test */
    function price_is_positive_number()
    {
        $response = $this->makeOffer([            
            'price' => -100 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('price', $errors['errors']);           
    } 

     /** @test */
    function price_is_not_higher_tenders_max_price()
    {
        $this->tender->update(['max_price' => 100]);

        $response = $this->makeOffer([            
            'price' => 200
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('price', $errors['errors']);           
    }    

    /** @test */
    function users_may_place_order_immediatly()
    {
        $this->makeOffer(['takeNow' => true]);

        $this->assertCount(1, $this->tender->offers);

        $order = Order::first();        
        
        $this->assertEquals($this->tender->id, $order->tender_id);        
        $this->assertEquals($this->tender->user_id, $order->tenderer_id);
        $this->assertCount(1, $this->tender->user->unreadNotifications);
    }

    /** @test */
    function users_may_place_order_at_not_active_tender()
    {
        $this->tender->update(['completed_at' => now()]);

        $this->makeOffer(['takeNow' => true])->assertStatus(403);
    }

    public function makeOffer($overrides = [])
    {
        $this->signIn($this->user);

        return $this->postJson('api/tenders/'.$this->tender->id.'/offers/store', array_merge([
            'price'=> 100
        ], $overrides));        
    }
}