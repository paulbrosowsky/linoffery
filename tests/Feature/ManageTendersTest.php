<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tender;

class ManageTendersTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function authenticated_users_may_view_own_tenders()
    {
        $this->signIn();
        create('App\Tender');
        create('App\Tender', ['user_id' => auth()->id()], 2);

        $this->assertCount(3, Tender::all());
        
        $response = $this->getJson('/api/dashboard/tenders')->json();
        
        $this->assertCount(2, $response);   
    }
}