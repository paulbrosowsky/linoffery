<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $order;

    public function setUp():void
    {
       parent::setUp();
       
       $this->order = create('App\Order');
    } 

    /** @test */
    function is_belongs_to_a_carrier()
    {
        $this->assertInstanceOf('App\User', $this->order->carrier);
    }

    /** @test */
    function is_belongs_to_a_tenderer()
    {
        $this->assertInstanceOf('App\User', $this->order->tenderer);
    }
    
    /** @test */
    function is_belongs_to_a_tender()
    {
        $this->assertInstanceOf('App\Tender', $this->order->tender);
    }

    /** @test */
    function is_belongs_to_a_offer()
    {
        $this->assertInstanceOf('App\Offer', $this->order->offer);
    }
   
      /** @test */
    function it_creats_own_unique_custom_id()
    {
        $order = create('App\Order');       
        
        $this->assertNotEmpty($order->fresh()->custom_id);        
    }

    /** @test */
    function it_knows_its_cost()
    {        
        $offer = create('App\Offer', ['price' => 100]);
        $this->order->update([
            'offer_id' => $offer->id
        ]);     
       
        $this->assertEquals(10, $this->order->cost);
    }

    
}