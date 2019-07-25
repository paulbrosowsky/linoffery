<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Hash;

class UpdateAccountTest extends PassportTestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();
        
        $this->user = create(\App\User::class);
        $this->withExceptionHandling();
        Mail::fake();
    }
    
    /** @test */
    function unauthorized_users_may_not_update_account()
    {
        $this->patchJson('/api/settings/account')
            ->assertStatus(401);        
    }

    /** @test */
    function authorized_users_may_update_thier_account()
    {               
        $this->updateAccount();

        tap( $this->user->fresh(), function($user){
            $this->assertEquals('John Doe', $user->name);
            $this->assertEquals('john@mail.me', $user->email);
            $this->assertEquals('CEO', $user->position);
            $this->assertEquals('+49123456789', $user->phone);
        });  
    }

       /** @test */
    function name_is_required()
    {
        $response = $this->updateAccount([
            'name' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('name', $errors['errors']);         
    }  

     /** @test */
    function email_is_required()
    {
        $response = $this->updateAccount([
            'email' => '' 
        ])->assertStatus(422); 
        
        $errors = $response->json();
        $this->assertArrayHasKey('email', $errors['errors']);         
    }  

    /** @test */
    function email_is_unique()
    {
        create('App\User', ['email' => 'john@mail.me' ]);

        $response = $this->updateAccount()->assertStatus(422);

        $errors = $response->json();
        $this->assertArrayHasKey('email', $errors['errors']);         
    }  

    /** @test */
   function a_confirmation_email_is_sent_on_email_changes()
   {   
        $this->updateAccount(); 
        Mail::assertQueued(ConfirmYourEmail::class);
   }

   /** @test */
   function a_user_can_update_his_password()
   {
        $user = create('App\User',['password' => Hash::make('secret')]);
        $this->signIn($user);

        $this->patchJson('/api/settings/password', [
            'old_password' => 'secret',
            'new_password' => 'password'
        ]); 
        
        $this->assertTrue(Hash::check('password', $user->password));
   }

   /** @test */
   function it_requires_valide_old_password()
   {
        $user = create('App\User',['password' => Hash::make('secret')]);
        $this->signIn($user);

        $response = $this->patchJson('/api/settings/password', [
            'old_password' => 'secretik',
            'new_password' => 'password'
        ])->assertStatus(422); 

        $errors = $response->json();        
        $this->assertArrayHasKey('old_password', $errors['errors']);    
   }

    protected function updateAccount($overrides = [])
    {        
        $this->signIn($this->user);
        
        return $this->patchJson('/api/settings/account', array_merge([ 
            'name' => 'John Doe',
            'email' => 'john@mail.me',
            'position' => 'CEO',
            'phone' => '+49123456789'

        ],$overrides));
    }


    
    
}