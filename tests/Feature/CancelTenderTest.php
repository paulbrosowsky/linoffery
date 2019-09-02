<?php


namespace Tests\Feature;

use App\Tender;
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

    /** @test */
    function owners_may_clone_tenders()
    {
        create('App\Location', ['tender_id' => $this->tender->id ], 2);
        create('App\Freight', ['tender_id' => $this->tender->id ], 2);
        $this->patchJson('api/tenders/'.$this->tender->id.'/cancel', [ 'withClone' => true ]);
        $tenders = Tender::all();          
        
        $this->assertCount(1, $tenders);
        $this->assertNotEquals($this->tender->id, $tenders[0]->id);
        $this->assertEquals($this->tender->title, $tenders[0]->title);
    }
    
}