<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Hash;

class ResetPasswordTest extends PassportTestCase
{
    use RefreshDatabase;  

    /** @test */
    function an_user_recieves_an_email_upon_submitting_his_email_adress()
    {
        Mail::fake();

        $user = create('App\User');

        $this->postJson('/api/auth/password/email', ['email' => $user->email]);       
        
        $this->assertNotEmpty($user->fresh()->password_reset_token);

        Mail::assertQueued(ResetPasswordEmail::class);           
         
    }

    /** @test */
    function valid_email_is_required()
    {
        $this->withExceptionHandling();

        $this->post('/api/auth/password/email', ['email' => 'invalid'])
            ->assertSessionHasErrors('email');  
    }

    /** @test */
    function existing_email_must_be_submitted()
    {
        $this->withExceptionHandling();

        $this->post('/api/auth/password/email', ['email' => 'john@mail.me'])
            ->assertSessionHasErrors('email');
    }

    /** @test */
    function user_can_reset_his_password()
    {
        Mail::fake();

        $user = create('App\User');

        $this->postJson('/api/auth/password/email', ['email' => $user->email]);   
        
        $this->postJson('/api/auth/password/reset?token='. $user->fresh()->password_reset_token, [
            'new_password' => 'secret'
        ]);
        
        $this->assertNull($user->fresh()->password_reset_token);        
        $this->assertTrue(Hash::check('secret', $user->fresh()->password));
    }


}