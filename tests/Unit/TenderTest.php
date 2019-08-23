<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TenderTest extends PassportTestCase
{
    use RefreshDatabase;
    
    protected $tender;

    public function setUp():void
    {
       parent::setUp();
       
       $this->tender = create('App\Tender');
    } 

    /** @test */
    function is_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->tender->user);
    }

    /** @test */
    function is_has_many_locations()
    {        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->tender->locations);
    }

     /** @test */
    function is_has_many_frights()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->tender->freights);
    }

     /** @test */
	function it_belongs_to_a_category()
	{   
		$this->assertInstanceOf('App\Category', $this->tender->category);		
    }   

    /** @test */
    function it_knows_the_lowest_offer()
    {
        $tender = create('App\Tender');
        $offer = create('App\Offer', [
            'tender_id' => $tender->id,
            'price' => 100
        ]);
        create('App\Offer', [
            'tender_id' => $tender->id,
            'price' => 200
        ]);
        
        $this->assertEquals(100, $tender->fresh()->lowest_offer);

        $offer->delete();
        $this->assertEquals(200, $tender->fresh()->lowest_offer);
    }
    
}