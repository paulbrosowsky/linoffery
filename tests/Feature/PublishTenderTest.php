<?php

namespace Tests\Feature ;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PublishTenderTest extends PassportTestCase
{
    use RefreshDatabase;
    
    protected $user;   
    protected $tender;

    public function setUp():void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->user = create('App\User'); 
        $this->tender = create('App\Tender', [
            'user_id' => $this->user->id,
            'published_at' => NULL
        ]);  

        $this->signIn($this->user);
    } 
    
    /** @test */
    function not_owners_may_not_update_tenders()
    {
        $this->signIn(); 

        $this->patchJson('/api/tenders/'.$this->tender->id.'/publish')
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_may_publish_thier_tenders()
    {
        $this->signIn($this->user);

        create('App\Location', ['tender_id' => $this->tender->id ]); 
        create('App\Freight', ['tender_id' => $this->tender->id ]);

        $this->patchJson('/api/tenders/'.$this->tender->id.'/publish');
                
        $this->assertNotEmpty($this->tender->fresh()->published_at);
    }

    /** @test */
    function tenders_data_must_be_completed_before_publishing()
    {
        $this->signIn($this->user);
              
        $this->patchJson('/api/tenders/'.$this->tender->id.'/publish')
            ->assertStatus(403);

    }
    
}