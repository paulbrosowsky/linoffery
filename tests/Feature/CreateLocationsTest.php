<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Location;

class CreateLocationsTest extends PassportTestCase
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
    function guests_may_not_create_locations()
    { 
        $this->postJson('api/locations/store')
            ->assertStatus(401);            
    }

    /** @test */
    function authenticated_users_may_create_locations()
    {
        $this->createLocation();    
        
        tap(Location::first(), function($location){
            $this->assertEquals('pickup', $location->type);
            $this->assertEquals($this->tender->id, $location->tender_id);
            $this->assertEquals('Hauptstr.2, 12345 Musterstadt, Deutschland', $location->address);
        });
    }

    /** @test */
    function a_user_must_confirm_his_email_address_to_create_a_location()
    {
        $this->user->update(['confirmed' => false]);

        $this->createLocation()->assertStatus(401);        
    }

    /** @test */
    function a_users_company_must_have_valid_address_to_create_a_location()
    { 
        $this->user->company->update(['address' => null]);  
             
        $this->createLocation()->assertStatus(401);        
    }  
    
    /** @test */
    function existing_tender_is_required()
    {
        $response = $this->createLocation([
            'tender_id' => '2' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('tender_id', $errors['errors']);         
    }  

    /** @test */
    function existing_type_is_required()
    {
        $response = $this->createLocation([
            'type' => 'dsgfdg' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('type', $errors['errors']);         
    } 

    /** @test */
    function address_is_required()
    {
        $response = $this->createLocation([
            'address' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('address', $errors['errors']);         
    } 

     /** @test */
    function lat_and_lng_are_numeric()
    {
        $response = $this->createLocation([
            'lat' => '',
            'lng' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('lat', $errors['errors']);
        $this->assertArrayHasKey('lng', $errors['errors']);           
    } 

      /** @test */
    function earliest_and_latest_date_are_required()
    {
        $response = $this->createLocation([
            'latest_date' => '',
            'earliest_date' => ''         
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('latest_date', $errors['errors']);    
        $this->assertArrayHasKey('earliest_date', $errors['errors']);                
    } 

    /** @test */
    function loading_start_and_loading_end_are_required()
    {
        $this->createLocation([
            'loading_start' => '',
            'loading_end' => ''         
        ])->assertStatus(422); 
    }
    
    public function createLocation($overrides = [])
    {
        $this->signIn($this->user);

        return $this->postJson('api/locations/store', array_merge([

            'tender_id' => $this->tender->id,
            'type' => 'pickup',
            'address' => 'Hauptstr.2, 12345 Musterstadt, Deutschland',
            'city' => 'Musterstadt',
            'country' => 'Deutschland',
            'lat' => 15,
            'lng' => 50,
            'latest_date' => \Carbon\Carbon::now(),
            'earliest_date' => \Carbon\Carbon::now()->addWeeks(1),
            'latency' => 2,
            'loading' => true,
            'exchage_pallet' => true,
            'loading_start' => '12:00',
            'loading_end' => '20:30'

        ], $overrides ));
        
    }

    
}
