<?php

namespace Tests\Features;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTendersTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function a_user_can_view_all_tenders()
    {
        create('App\Tender', [], 3);

        $response = $this->getJson('api/tenders')->json();
        
        $this->assertCount(3, $response['data']);        
    }

    /** @test */
    function a_user_can_view_a_single_tender()    
    {
        $tender = create('App\Tender');

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);  
    }
    
}