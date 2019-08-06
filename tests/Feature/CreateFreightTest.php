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
        $this->tender = create('App\Tender');   
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
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('tender_id', $errors['errors']);         
    }  
    

    /** @test */
    function title_is_required()
    {
        $response = $this->createFreight([
            'title' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('title', $errors['errors']);         
    } 

     /** @test */
    function pallet_is_required()
    {
        $response = $this->createFreight([
            'pallet' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('pallet', $errors['errors']);         
    }      

      /** @test */
    function weight_is_required()
    {
        $response = $this->createFreight([
            'weight' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('weight', $errors['errors']);         
    }    
    
    public function createFreight($overrides = [])
    {
        $this->signIn($this->user);

        return $this->postJson('api/freights/store', array_merge([

            'tender_id' => $this->tender->id,
            'title' => 'New Freight',
            'description' => 'New Freight Description',
            'pallet' => 'EPAL',
            'weight' => 100,
            'width' => 100,
            'height' => 100,
            'depth' => 100,           

        ], $overrides ));
        
    }

    
}
