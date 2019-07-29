<?php

namespace Tests\Auth\Feature;

use Tests\PassportTestCase;
use App\Mail\ConfirmYourEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;


class SendConfirmationEmailTest extends PassportTestCase
{
    use RefreshDatabase;
    
     /** @test */
   function a_user_can_send_a_confirmation_email_again()
   {    
        Mail::fake();

        $user = create('App\User', ['confirmed' => false]);

        $this->signIn($user);

        $this->getJson('/api/auth/email-confirmation/email');
        
        Mail::assertQueued(ConfirmYourEmail::class);
   }
}