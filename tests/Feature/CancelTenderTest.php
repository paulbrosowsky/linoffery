<?php


namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CancelTenderTest extends PassportTestCase
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
            'user_id' => $this->user->id            
        ]);
        
        $this->signIn($this->user);
    }  
    
    /** @test */
    function not_owners_can_not_cancel_tenders()
    {
        $this->signIn()->withExceptionHandling();       

        $this->patchJson('api/tenders/1/cancel')
            ->assertStatus(403);
    }

    /** @test */
    function owners_can_cancel_tenders()
    {
        $this->assertEmpty($this->tender->completed_at);
        $this->patchJson('api/tenders/'.$this->tender->id.'/cancel');

        $this->assertNotEmpty($this->tender->fresh()->completed_at);
    }
    
}