<?php

namespace Tests\Feature\Auth;

use App\User;
use App\Company;
use Tests\TestCase;
use App\Mail\ConfirmYourEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

// use TimeHunter\LaravelGoogleReCaptchaV3\Validations\GoogleReCaptchaV3ValidationRule;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();   
        $this->withExceptionHandling();        
    }

    /** @test */
    function an_user_can_register_an_account()
    {        
       $this->registerAccount()->json();
        
       $this->assertCount(1, User::all());

        tap(User::first(), function($user){
            $this->assertEquals('John Doe', $user->name);            
            $this->assertEquals('john@mail.me', $user->email);
            $this->assertTrue(Hash::check('secret', $user->password));            
        });
    }

    /** @test */
    function a_company_will_be_created_upon_registration()
    {
        $this->registerAccount();

        $this->assertCount(1, Company::all());
 
        tap(Company::first(), function($company){
            $this->assertEquals('Secret Ltd.', $company->name);            
            $this->assertEquals('IE6388047V', $company->vat);            
        });
    }

    /** @test */
    function name_is_required()
    {             

        $this->registerAccount([
            'name' => ''
        ])->assertStatus(422);  
    }  

    /** @test */
    function email_is_required()
    {  
        $this->registerAccount([
            'email' => ''
        ])->assertStatus(422);     
    }

    /** @test */
    function email_is_valide()
    {
        $response = $this->registerAccount([
            'email' => 'not-valid-email'
        ])->assertStatus(422);        
    }

    /** @test */
    function email_cannot_exeed_255_chars()
    {   
        $this->registerAccount([
            'email' => substr(str_repeat('a', 256) . '@example.com', -256),
        ])->assertStatus(422);     
    }

    /** @test */
    function email_is_unique()
    {
        create(\App\User::class, ['email' => 'john@mail.me']);

        $this->registerAccount()->assertStatus(422);          
    }

    /** @test */
    function password_is_required()
    {
        $response = $this->registerAccount([
            'password' => ''
        ])->assertStatus(422);
    }

    /** @test */
    function password_must_have_6_chars()
    {
        $this->registerAccount([
            'password' => 'sec' ,
            'password_confirmation' => 'sec'          
        ])->assertStatus(422);
    }

     /** @test */
    function company_name_is_required()
    {
        $response = $this->registerAccount([
            'company_name' => ''
        ])->assertStatus(422);       
    }

    /** @test */
    function vat_number_is_required()
    {
        $this->registerAccount([
            'vat' => ''
        ])->assertStatus(422);
    }

    /** @test */
    function vat_is_unique()
    {
        create(\App\Company::class, ['vat' => 'IE6388047V']);
        $this->registerAccount()->assertStatus(422);
    }

    // /** @test */
    // function vat_must_be_valide()
    // { 
    //    $this->registerAccount( ['vat' => 'DE12345678'])->assertStatus(422);
    // }

    // /** @test */
    // function terms_must_be_confirmed()
    // {  
    //     $this->registerAccount( ['terms_accepted' => ''])->assertStatus(422);
    //     // $this->registerAccount( ['payment_terms_accepted' => ''])->assertStatus(422);
    // }

   /** @test */
   function a_confirmation_email_is_sent_upon_registration()
   {    
        Mail::fake();

        $this->registerAccount();         
        
        Mail::assertQueued(ConfirmYourEmail::class);
   }

   /** @test */
   function user_can_fully_confirm_thier_email_addresses()
   {   
        $this->registerAccount();       

        $user = User::whereName('John Doe')->first();  
       
        $this->assertFalse($user->confirmed); 
        $this->assertNotEmpty($user->confirmation_token);
                
        $this->get( '/api/auth/email-confirmation/confirm?token=' . $user->confirmation_token)
            ->assertRedirect('/');

        tap($user->fresh(), function($user){
            $this->assertTrue($user->fresh()->confirmed); 
            $this->assertNull($user->fresh()->confirmation_token); 
        });            
   }   

    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get('/api/auth/email-confirmation/confirm?token=invalid')
            ->assertRedirect('/');            
    }   

    protected function registerAccount($overrides = [])
    {
        return $this->postJson('/api/auth/register', array_merge([
            'name' => 'John Doe',
            'email' => 'john@mail.me',
            'password' =>'secret',
            'company_name' => 'Secret Ltd.',
            'vat' => 'IE6388047V', // Google Ireland,
            'address' => 'street 5',
            'city' => 'paris',
            'postcode' => '12345',
            'country' => 'deutschland',
            'terms_accepted' => true,
            'payment_terms_accepted' => true,
        ],$overrides));        
    }
    
}