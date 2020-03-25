<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateCompanyTest extends PassportTestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        $this->withExceptionHandling();
    }
    
     /** @test */
    function unauthorized_users_may_not_update_account()
    {   
        $this->patchJson('/api/settings/company')
            ->assertStatus(401);        
    }

    /** @test */
    function authenticated_users_may_update_thier_companys_data()
    {
        $this->updateCompany();

        tap(auth()->user()->company->fresh(), function($company){
            $this->assertEquals('Firma', $company->name);
            $this->assertEquals('IE6388047V', $company->vat);
        });
    }

    /** @test */
    function name_is_required()
    {
        $response = $this->updateCompany([
            'name' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('name', $errors['errors']);         
    }

     /** @test */
    function vat_is_required()
    {
        $response = $this->updateCompany([
            'vat' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('vat', $errors['errors']);         
    }

      /** @test */
    function vat_is_unique()
    {
        create('App\Company', ['vat' => 'IE6388047V' ]);

        $response = $this->updateCompany()->assertStatus(422);

        $errors = $response->json();        
        $this->assertArrayHasKey('vat', $errors['errors']);         
    }  

    // /** @test */
    // function vat_must_be_valide()
    // { 
    //     $this->withExceptionHandling();        

    //     $response = $this->updateCompany( ['vat' => 'DE12345678']);

    //     $errors = $response->json();   
    //     $this->assertArrayHasKey('vat', $errors['errors']);            
    // }

     /** @test */
    function address_is_required()
    {
        $response = $this->updateCompany([
            'address' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('address', $errors['errors']);         
    }

     /** @test */
    function city_is_required()
    {
        $response = $this->updateCompany([
            'city' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('city', $errors['errors']);         
    }

      /** @test */
    function postcode_is_required()
    {
        $response = $this->updateCompany([
            'postcode' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('postcode', $errors['errors']);         
    }

      /** @test */
    function country_is_required()
    {
        $response = $this->updateCompany([
            'country' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('country', $errors['errors']);         
    }

    protected function updateCompany($overrides = [])
    {   
        $this->signIn();

        return $this->patchJson('/api/settings/company', array_merge([

            'name' => 'Firma',
            'vat' => 'IE6388047V', // Google Ireland
            'country' =>'Deutschland',
            'city' => 'Berlin',
            'postcode' => '12345', 
            'address' => 'Poststr.5',
            'lat' => 45.868,
            'lng' => 6.6757,
            'website' => 'firma.de'  

        ], $overrides));        
    }
}