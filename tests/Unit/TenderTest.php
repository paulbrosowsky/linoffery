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
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->tender->frights);
    }

     /** @test */
	function it_belongs_to_a_category()
	{   
		$this->assertInstanceOf('App\Category', $this->tender->category);		
    }
    
}