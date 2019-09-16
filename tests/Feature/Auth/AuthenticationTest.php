<?php

namespace Tests\Feature\Auth;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends PassportTestCase
{
    use RefreshDatabase;
    public function setUp():void
    {
        parent::setUp();

        $this->user = create('App\User',[
            'email' => 'john@mail.me',
            'password' => bcrypt('secret')
        ]);
    }

    /** @test */
    function  a_user_can_login()
    {          
        $this->login([
            'password' => 'not valide'
        ])->assertStatus(401);        
        
        $this->login()->assertStatus(200); 
         
    }

    /** @test */
    function auth_user_can_logout()
    {        
        $this->signIn($this->user);

        $this->getJson('/api/auth/logout')->assertStatus(200);
    } 

    /** @test */
    function authenticated_users_can_fetch_thier_user_data()
    {
        $this->signIn($this->user);
        
        $response = $this->getJson('api/auth/user')->json();

        $this->assertEquals($this->user->email, $response['email']); 
    }    

    protected function login($overrides = [])
    {
        return $this->post('/api/auth/login', array_merge([            
            'email' => 'john@example.com',
            'password' => 'password'           
        ],$overrides));        
    }
}