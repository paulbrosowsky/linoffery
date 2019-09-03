<?php


namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewCompanyProfile extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function guest_may_not_view_company_profiles()
    {
        $this->withExceptionHandling();
        $this->getJson('api/profiles/1')->assertStatus(401);
    }

    /** @test */
    function authenticated_users_may_view_companies_profile()
    {        
        $company = create('App\Company');
        create('App\Comment', ['company_id' => $company->id], 2);

        $this->signIn();

        $response = $this->getJson('api/profiles/'.$company->id)->json();

        $this->assertEquals($company->name, $response['name']);  
        $this->assertCount(2, $response['comments']);      
    } 
    
}