<?php

namespace Tests\Feature;

use App\Location;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateLocationsTest extends PassportTestCase
{
    use RefreshDatabase;
    
    protected $user;
    protected $tender;
    protected $locaton;

    public function setUp():void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->user = create('App\User');
        $this->tender = create('App\Tender', [
            'user_id' => $this->user->id,
            'published_at' => NULL
        ]); 
        $this->location = create('App\Location', [
            'tender_id' => $this->tender->id 
        ]);

        $this->signIn($this->user);
    }  

    /** @test */
    function not_tenders_owners_may_not_update_tenders()
    {
        $this->signIn(); 
        $this->updateLocation()->assertStatus(403);
    }

    /** @test */
    function only_unpublished_tenders_location_may_be_updated()
    {   
        $this->tender->update(['published_at' => \Carbon\Carbon::now()]);  
        $this->updateLocation()->assertStatus(403);
    }
   

    /** @test */
    function owners_may_update_locations()
    {
        $this->updateLocation();    
        
        tap(Location::first(), function($location){                    
            $this->assertEquals('Hauptstr.2, 12345 Musterstadt, Deutschland', $location->address);
        });
    } 

    /** @test */
    function address_is_required()
    {
        $response = $this->updateLocation([
            'address' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('address', $errors['errors']);         
    } 

     /** @test */
    function lat_and_lng_are_numeric()
    {
        $response = $this->updateLocation([
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
        $response = $this->updateLocation([
            'latest_date' => '',
            'earliest_date' => ''         
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('latest_date', $errors['errors']);    
        $this->assertArrayHasKey('earliest_date', $errors['errors']);                
    } 
    
    public function updateLocation($overrides = [])
    {       

        return $this->patchJson('api/locations/'.$this->location->id.'/update', array_merge([                     
            'address' => 'Hauptstr.2, 12345 Musterstadt, Deutschland',
            'lat' => 15,
            'lng' => 50,
            'latest_date' => \Carbon\Carbon::now(),
            'earliest_date' => \Carbon\Carbon::now()->addWeeks(1),
            'latency' => 2,
            'loading' => true

        ], $overrides ));
        
    }
    
}
