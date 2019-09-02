<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OfferTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $offer;

    public function setUp():void
    {
       parent::setUp();
       
       $this->offer = create('App\Offer');
    } 

    /** @test */
    function is_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->offer->user);
    }
    
    /** @test */
    function is_belongs_to_a_tender()
    {
        $this->assertInstanceOf('App\Tender', $this->offer->tender);
    }

    /** @test */
    function it_has_one_order()
    {
        create('App\Order', ['offer_id'=> $this->offer->id]);        
        $this->assertInstanceOf('App\Order', $this->offer->order);
    }

     /** @test */
    function it_creats_own_unique_custom_id()
    {
        $offer = create('App\Offer');       
        
        $this->assertNotEmpty($offer->fresh()->custom_id);        
    }

    
}