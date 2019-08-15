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
   

    
}