<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Tender;

class UpdateTenderTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;
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
        $this->category = create('App\Category'); 
        
        $this->signIn($this->user);
    }  

    /** @test */
    function not_owners_may_not_update_tenders()
    {
        $this->signIn(); 
        $this->updateTender()->assertStatus(403);
    }

    /** @test */
    function only_unpublished_tenders_may_be_updated()
    {   
        $this->tender->update(['published_at' => \Carbon\Carbon::now()]);  
        $this->updateTender()->assertStatus(403);
    }

     /** @test */
    function owners_may_update_tenders()
    {
        $this->updateTender();    

        tap(Tender::first(), function($tender){
            $this->assertEquals('Update Tender', $tender->title);
            $this->assertEquals($this->category->id, $tender->category_id);            
        });
    }

      /** @test */
    function title_is_required()
    {
        $response = $this->updateTender([
            'title' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('title', $errors['errors']);         
    } 
    
    /** @test */
    function existing_category_is_required()
    {
        $response = $this->updateTender([
            'category_id' => '999' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('category_id', $errors['errors']);         
    }  

     /** @test */
    function price_is_numeric()
    {
        $response = $this->updateTender([            
            'max_price' => 'abc' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        
        $this->assertArrayHasKey('max_price', $errors['errors']);           
    } 

      /** @test */
    function valid_date_is_required()
    {
        $response = $this->updateTender([
            'valid_date' => '',            
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('valid_date', $errors['errors']);                 
    } 

    public function updateTender( $overrides = [])
    {  
        return $this->patchJson('api/tenders/'.$this->tender->id.'/update', array_merge([

            'title' => 'Update Tender',
            'category_id' => $this->category->id,
            'description' => 'Update Tenders Description',
            'immediate_price' => 100,
            'max_price' => 200,
            'valid_date' => \Carbon\Carbon::now()

        ], $overrides ));        
    }
}