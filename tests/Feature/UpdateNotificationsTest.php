<?php


namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateNotificationsTest extends PassportTestCase
{
    use RefreshDatabase;

    /** @test */
    function users_may_disable_thier_newsletters()
    {
        $this->signIn();
        $this->assertTrue(auth()->user()->newsletters);

        $this->patchJson("api/settings/newsletters");
        
        $this->assertFalse(auth()->user()->newsletters);

    }
  
    
}