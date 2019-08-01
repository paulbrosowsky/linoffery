<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LocationTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $location;

    public function setUp():void
    {
       parent::setUp();
       
       $this->location = create('App\Location');
    } 
    
    /** @test */
    function is_belongs_to_a_tender()
    {
        $this->assertInstanceOf('App\Tender', $this->location->tender);
    }
    
}