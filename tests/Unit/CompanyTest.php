<?php

namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $company;
    protected $user;

    public function setUp():void
    {
       parent::setUp();
       
       $this->company = create('App\Company');
       $this->user = create('App\User', ['company_id' => $this->company]);
    } 
    
      /** @test */
    function it_creats_own_unique_custom_id()
    {        
        $this->assertNotEmpty($this->company->fresh()->custom_id);        
    }

      /** @test */
    function is_has_many_commnets()
    {  
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->company->comments);
    }

    /** @test */
    function it_has_one_user()
    {
        $this->assertInstanceOf('App\User', $this->company->user);
    }

    /** @test */
    function it_knows_how_many_shipmnets_has_been_made()
    {
        create('App\Order', ['carrier_id' => $this->user->id], 2);

        $this->assertEquals(2, $this->company->shipmentCount);
    }

    /** @test */
    function it_knows_how_many_tender_it_has()
    {
        create('App\Tender', ['user_id' => $this->user->id], 2);       

        $this->assertEquals(2, $this->company->tenderCount);
    }

    /** @test */
    function it_knows_his_rating()
    {   
        create('App\Comment', [
            'company_id' => $this->company->id,
            'rating' => 3
        ], 2);

        $this->assertEquals(3, $this->company->rating);
    }  

    /** @test */
    function it_knows_if_all_required_fields_are_completed()
    {
        $company = create('App\Company',[
            'address' => NULL,
            'postcode' => NULL,
            'city' => NULL,
            'country' => NULL,
            'vat_validated_at' => NULL
        ]);
        $this->assertFalse($company->completed);

        $company->update([
            'address' => 'Poststr.6',
            'postcode' => '12345',
            'city' => 'Berlin',
            'country' => 'Germany',
            'vat_validated_at' => now()
        ]);
        $this->assertTrue($company->completed);
    }
   
}