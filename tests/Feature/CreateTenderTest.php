<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tender;

class CreateTenderTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    public function setUp():void
    {
        parent::setUp();

        $this->withExceptionHandling();

        $this->user = create('App\User');
        $this->category = create('App\Category');   
    }
    
    /** @test */
    function guests_may_not_create_tenders()
    { 
        $this->postJson('api/tenders/store')
            ->assertStatus(401);            
    }

    /** @test */
    function authenticated_users_may_create_tenders()
    {
        $this->createTender();    

        tap(Tender::first(), function($tender){
            $this->assertEquals('New Tender', $tender->title);
            $this->assertEquals($this->category->id, $tender->category_id);
            $this->assertEquals($this->user->id, $tender->user_id);
        });
    }

    /** @test */
    function a_user_must_confirm_his_email_address_to_create_a_tender()
    {
        $this->user->update(['confirmed' => false]);

        $this->createTender()->assertStatus(401);        
    }

    /** @test */
    function a_users_company_must_have_valid_address_to_create_a_tender()
    { 
        $this->user->company->update(['address' => null]);  
             
        $this->createTender()->assertStatus(401);        
    }

     /** @test */
    function title_is_required()
    {
        $response = $this->createTender([
            'title' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('title', $errors['errors']);         
    } 
    
    /** @test */
    function existing_category_is_required()
    {
        $response = $this->createTender([
            'category_id' => '2' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('category_id', $errors['errors']);         
    }  

     /** @test */
    function price_is_numeric()
    {
        $response = $this->createTender([            
            'max_price' => 'abc' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('max_price', $errors['errors']);           
    } 

      /** @test */
    function valid_date_is_required()
    {
        $response = $this->createTender([
            'valid_date' => '',            
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('valid_date', $errors['errors']);                 
    } 
    
    public function createTender($overrides = [])
    {
        $this->signIn($this->user);

        return $this->postJson('api/tenders/store', array_merge([

            'title' => 'New Tender',
            'category_id' => $this->category->id,
            'description' => 'New Tenders Description',
            'immediate_price' => 100,
            'max_price' => 200,
            'valid_date' => \Carbon\Carbon::now()

        ], $overrides ));
        
    }
}