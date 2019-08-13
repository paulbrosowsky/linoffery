<?php

namespace Tests\Features;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tender;
use Carbon\Carbon;

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

    /** @test */
    function users_can_view_only_published_tenders()
    {
        create('App\Tender');
        create('App\Tender', ['published_at' => null]);

        $this->assertCount(2, Tender::all()); 

        $response = $this->getJson('api/tenders')->json();
        
        $this->assertCount(1, $response['data']);  
    }

    /** @test */
    function not_owners_may_not_view_unpublished_tenders()
    {
        $this->withExceptionHandling();

        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'published_at' => null
        ]);

        $this->signIn();        

        $this->getJson('api/tenders/'.$tender->id)
            ->assertStatus(403);
    }

    /** @test */
    function not_owners_may_not_view_completed_tenders()
    {
        $this->withExceptionHandling();

        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'completed_at' => Carbon::now()
        ]);

        $this->signIn();        

        $this->getJson('api/tenders/'.$tender->id)
            ->assertStatus(403);
    }

    /** @test */
    function only_owners_can_view_unpublished_tenders()
    { 
        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'published_at' => null
        ]);

        $this->signIn($user);        

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);             
    }

    /** @test */
    function only_owners_can_view_completed_tenders()
    { 
        $user = create('App\User');
        $tender = create('App\Tender', [
            'user_id' => $user->id,
            'completed_at' => Carbon::now()
        ]);

        $this->signIn($user);        

        $response = $this->getJson('api/tenders/'.$tender->id)->json();

        $this->assertContains($tender->title, $response['title']);             
    }
    
}