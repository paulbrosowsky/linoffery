<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp():void
    {
       parent::setUp();
       
       $this->user = create('App\User');
    } 

    /** @test */
    function is_belongs_to_a_company()
    {
        $this->assertInstanceOf('App\Company', $this->user->company);
    }

    /** @test */
    function is_has_many_tenders()
    {        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->tenders);
    }

    /** @test */
    function is_has_many_offers()
    {        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->user->offers);
    }
    
    
}