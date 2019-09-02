<?php


namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyTest extends PassportTestCase
{
    use RefreshDatabase;
    
      /** @test */
    function it_creats_own_unique_custom_id()
    {
        $company = create('App\Company');
        $this->assertNotEmpty($company->fresh()->custom_id);        
    }
    
}