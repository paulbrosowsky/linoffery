<?php

namespace Tests\Feature;

use App\Freight;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateFreightTest extends PassportTestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $tender;
    protected $freight;

    public function setUp():void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->user = create('App\User');
        $this->tender = create('App\Tender', [
            'user_id' => $this->user->id,
            'published_at' => NULL
        ]); 
        $this->freight= create('App\Freight', [
            'tender_id' => $this->tender->id 
        ]);

        $this->signIn($this->user);
    }  

    /** @test */
    function not_tenders_owners_may_not_update_freights()
    {
        $this->signIn(); 
        $this->updateFreight()->assertStatus(403);
    }

    /** @test */
    function only_unpublished_tenders_freights_may_be_updated()
    {   
        $this->tender->update(['published_at' => \Carbon\Carbon::now()]);  
        $this->updateFreight()->assertStatus(403);
    }   

    /** @test */
    function owners_may_update_freight()
    {
        $this->updateFreight();    
        
        tap(Freight::first(), function($freight){                    
            $this->assertEquals('Update Freight', $freight->title); 
            $this->assertEquals(100, $freight->weight);
        });
    } 
    
    public function updateFreight($overrides = [])
    { 
        $freights = make('App\Freight', array_merge([
            'tender_id' => $this->tender->id,
            'title' => 'Update Freight',
            'description' => 'Update Freight Description',
            'pallet' => 'EPAL',
            'weight' => 100,
            'width' => 100,
            'height' => 100,
            'depth' => 100, 
        ], $overrides), 2);

        return $this->postJson('api/freights/store', ['freights' => $freights ]);          
        
    }
    
}
