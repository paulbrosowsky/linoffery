<?php

namespace Tests\Feature;

use App\Tender;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteTenderTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $tender;

    public function setUp():void
    {
        parent::setUp();

        $this->signIn();
        $this->withExceptionHandling();

        $this->tender = create('App\Tender', [
            'user_id' => auth()->id(),
            'completed_at' => now()
        ]);
    }
    
    /** @test */
    function unauthorized_users_my_not_delete_tenders()
    {  
        $this->signIn(create('App\User'));
        $this->deleteJson('api/tenders/'.$this->tender->id.'/destroy')->assertStatus(403);
    }

     /** @test */
    function uncomplete_tenders_may_not_be_deleted()
    {
        $this->tender->update(['completed_at' => NULL]);
        $this->deleteJson('api/tenders/'.$this->tender->id.'/destroy')->assertStatus(403);
    }   

    /** @test */
    function tenders_with_order_may_not_be_deleted()
    {
        create('App\Order', [
            'tender_id' => $this->tender->id
        ]);
        
        $this->deleteJson('api/tenders/'.$this->tender->id.'/destroy')->assertStatus(403);
    }

    /** @test */
    function owners_may_delete_thier_tenders()
    {
        $location = create('App\Location', ['tender_id' => $this->tender->id]);
        $freight = create('App\Freight', ['tender_id' => $this->tender->id]);

        $this->assertDatabaseHas('tenders', ['id' => $this->tender->id]);

        $this->deleteJson('api/tenders/'.$this->tender->id.'/destroy');

        $this->assertDatabaseMissing('tenders', ['id' => $this->tender->id]);
        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
        $this->assertDatabaseMissing('freights', ['id' => $freight->id]);
    }

    /** @test */
    function owners_may_clone_tenders()
    {       
        create('App\Location', ['tender_id' => $this->tender->id ], 2);
        create('App\Freight', ['tender_id' => $this->tender->id ], 2);
        $this->deleteJson('api/tenders/'.$this->tender->id.'/destroy', [ 'withClone' => true ]);
        $tenders = Tender::all();          
        
        $this->assertCount(1, $tenders);
        $this->assertNotEquals($this->tender->id, $tenders[0]->id);
        $this->assertEquals($this->tender->title, $tenders[0]->title);
    }
}