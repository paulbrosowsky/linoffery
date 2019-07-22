<?php

namespace Tests\Feature\Auth;

use App\User;
use App\Company;
use Tests\TestCase;
use App\Mail\ConfirmYourEmail;
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

       

        // Pass Recaptcha validation without the Rule
		// app()->singleton(GoogleReCaptchaV3ValidationRule::class, function (){
            
		// 	$m = \Mockery::mock(GoogleReCaptchaV3ValidationRule::class, function ($m){                
        //         $m->shouldReceive('passes')->andReturn(true);               
        //     });            
        //     return $m;
			
		// });
    }

    /** @test */
    function an_user_can_register_an_account()
    {        
       $this->registerAccount();

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
            $this->assertEquals('DE12345678', $company->vat);            
        });
    }

    /** @test */
    function name_is_required()
    {
        $this->withExceptionHandling();        

        $response = $this->registerAccount([
            'name' => ''
        ]);
        
        $response->assertSessionHasErrors('name');        
        $this->assertCount(0, User::all());
    }  

    /** @test */
    function email_is_required()
    {
        $this->withExceptionHandling();        

        $response = $this->registerAccount([
            'email' => ''
        ]);
        
        $response->assertSessionHasErrors('email');        
        $this->assertCount(0, User::all());
    }

    /** @test */
    function email_is_valide()
    {
        $this->withExceptionHandling();         
 
        $response = $this->registerAccount([
            'email' => 'not-valid-email'
        ]); 
         
        $response->assertSessionHasErrors('email');        
        $this->assertCount(0, User::all());
    }

    /** @test */
    function email_cannot_exeed_255_chars()
    {   
        $this->withExceptionHandling();        

        $response = $this->registerAccount([
            'email' => substr(str_repeat('a', 256) . '@example.com', -256),
        ]);
       
        $response->assertSessionHasErrors('email');        
        $this->assertCount(0, User::all());
    }

    /** @test */
    function email_is_unique()
    {
        create(\App\User::class, ['email' => 'john@mail.me']);

        $this->withExceptionHandling();        

        $response = $this->registerAccount();
        
        $response->assertSessionHasErrors('email');
             
    }

    /** @test */
    function password_is_required()
    {
        $this->withExceptionHandling();
        

        $response = $this->registerAccount([
            'password' => ''
        ]);
        
        $response->assertSessionHasErrors('password');        
        $this->assertCount(0, User::all());
    }

    /** @test */
    function password_must_have_6_chars()
    {
        $this->withExceptionHandling();        
 
        $response = $this->registerAccount([
            'password' => 'sec' ,
            'password_confirmation' => 'sec'          
        ]); 
        
        $response->assertSessionHasErrors('password');        
        $this->assertCount(0, User::all());
    }

     /** @test */
    function company_name_is_required()
    {
        $this->withExceptionHandling();        
 
        $response = $this->registerAccount([
            'company_name' => ''
        ]);
         
        $response->assertSessionHasErrors('company_name');        
        $this->assertCount(0, Company::all());
    }

    /** @test */
    function vat_number_is_required()
    {
        $this->withExceptionHandling();        
 
        $response = $this->registerAccount([
            'vat' => ''
        ]);
         
        $response->assertSessionHasErrors('vat');        
        $this->assertCount(0, Company::all());
    }

    /** @test */
    function vat_is_unique()
    {
        create(\App\Company::class, ['vat' => 'DE12345678']);

        $this->withExceptionHandling();        

        $response = $this->registerAccount();
        
        $response->assertSessionHasErrors('vat');
             
    }

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
        $this->assertNotNull($user->confirmation_token);  

        $this->get( '/api/auth/email-confirmation/confirm?token=' . $user->confirmation_token)
            ->assertRedirect('/dashboard');

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

    // /** @test */
    // function recaptcha_validation_is_required()
    // {
    //     unset(app()[GoogleReCaptchaV3ValidationRule::class]);

    //     $this->withExceptionHandling();
       
    //     $this->registerAccount(['gRecaptchaResponse' => 'test'])
    //         ->assertSessionHasErrors('gRecaptchaResponse');
    // }

    protected function registerAccount($overrides = [])
    {
        return $this->post('/api/auth/register', array_merge([
            'name' => 'John Doe',
            'email' => 'john@mail.me',
            'password' =>'secret',
            'company_name' => 'Secret Ltd.',
            'vat' => 'DE12345678'
        ],$overrides));        
    }
    
}