<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Freight;

class CreateFreightTest extends PassportTestCase
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
    }
    
    /** @test */
    function guests_may_not_create_freights()
    { 
        $this->postJson('api/freights/store')
            ->assertStatus(401);            
    }

    /** @test */
    function authenticated_users_may_create_freights()
    {
        $this->createFreight();
        
        tap(Freight::first(), function($freight){
            $this->assertEquals('New Freight', $freight->title);  
            $this->assertEquals($this->tender->id, $freight->tender_id);          
            $this->assertEquals(100, $freight->weight);
            $this->assertEquals(100, $freight->width);
            $this->assertEquals(100, $freight->depth);
            $this->assertEquals(100, $freight->height);
        });
    }

    /** @test */
    function a_user_must_confirm_his_email_address_to_create_a_freight()
    {
        $this->user->update(['confirmed' => false]);

        $this->createFreight()->assertStatus(401);        
    }

    /** @test */
    function a_users_company_must_have_valid_address_to_create_a_freight()
    { 
        $this->user->company->update(['address' => null]);  
             
        $this->createFreight()->assertStatus(401);        
    }  
    
    /** @test */
    function existing_tender_is_required()
    {
        $response = $this->createFreight([
            'tender_id' => '2' 
        ])->assertStatus(403);               
    }  
    

    /** @test */
    function title_is_required()
    {
        $response = $this->createFreight([
            'title' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();        
        $this->assertArrayHasKey('freights.0.title', $errors['errors']);         
    } 

     /** @test */
    function pallet_is_required()
    {
        $response = $this->createFreight([
            'pallet' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('freights.0.pallet', $errors['errors']);         
    }      

      /** @test */
    function weight_is_required()
    {
        $response = $this->createFreight([
            'weight' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('freights.0.weight', $errors['errors']);         
    }    

    /** @test */
    function a_user_can_fetch_all_trasport_types()
    {
        create('App\TransportType');
        $response = $this->getJson('/api/transport-types')->json();
        
        $this->assertCount(1, $response);
    }
    
    public function createFreight($overrides = [])
    {
        $this->signIn($this->user);

        $freights = make('App\Freight', array_merge([
            'tender_id' => $this->tender->id,
            'title' => 'New Freight',
            'description' => 'New Freight Description',
            'pallet' => 'EPAL',
            'weight' => 100,
            'width' => 100,
            'height' => 100,
            'depth' => 100, 
        ], $overrides), 2);

        return $this->postJson('api/freights/store', ['freights' => $freights ]);        
    }
    
}
