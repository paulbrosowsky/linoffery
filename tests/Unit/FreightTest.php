<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FreightTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $freight;

    public function setUp():void
    {
       parent::setUp();
       
       $this->freight = create('App\Freight');
    } 
    
    /** @test */
    function is_belongs_to_a_tender()
    {
        $this->assertInstanceOf('App\Tender', $this->freight->tender);
    }

    /** @test */
    function is_belongs_to_a_transport_type()
    {
        $this->assertInstanceOf('App\TransportType', $this->freight->transportType);
    }
    
}