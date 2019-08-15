<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOffersTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $tender;
    protected $user;
    protected $offer;
    
    public function setUp():void
    {
        parent::setup();

        // $this->withExceptionHandling();
        
        $this->user = create('App\User');
        $this->tender = create('App\Tender', ['user_id' => $this->user->id]);        
    }

    /** @test */
    function guest_may_not_view_offers()
    {        
        $response = $this->viewTender();

        $this->assertCount(3, $this->tender->offers);
        $this->assertEmpty($response['offers']);
    }

    /** @test */
    function not_tenders_or_offers_owners_may_not_view_offers()
    {        
        $this->signIn();
        $response = $this->viewTender();
        
        $this->assertCount(3, $this->tender->offers);         
        $this->assertEmpty($response['offers']);
    }

    /** @test */
    function offer_owner_can_view_thier_offers()
    {
        $user = create('App\User');
        create('App\Offer', [
            'user_id' => $user->id,
            'tender_id' => $this->tender->id
        ]);

        $this->signIn($user);
        $response = $this->viewTender();

        $this->assertCount(4, $this->tender->offers);  
        $this->assertCount(1, $response['offers']);
        $this->assertEquals($user->id, $response['offers'][0]['user_id']);
    }
    
    /** @test */
    function only_tender_owners_may_view_all_offers()
    {         
        $this->signIn($this->user);
        $response = $this->viewTender();
        
        $this->assertCount(3, $response['offers']);
    }

    /** @test */
    function owners_can_view_all_thier_offers()
    {        
        create('App\Offer', ['user_id' => $this->user->id], 3);

        $this->signIn();
        $response = $this->getJson('api/offers')->json();        
        $this->assertCount(0, $response);

        $this->signIn($this->user);
        $response = $this->getJson('api/offers')->json();        
        $this->assertCount(3, $response);
    }

    public function viewTender()
    {
        create('App\Offer', ['tender_id' => $this->tender->id], 3);
        return $this->getJson('api/tenders/'.$this->tender->id)->json();
    }
}