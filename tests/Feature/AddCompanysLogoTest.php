<?php
namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class AddCompanysLogoTest extends PassportTestCase
{
    use RefreshDatabase;

   /** @test */
   function only_members_can_add_logo()
   {
        $this->withExceptionHandling();

        $this->postJson('/api/settings/company/logo')
            ->assertStatus(401);
   }

   /** @test */
   function a_valide_logo_must_be_provided()
   {
        $this->withExceptionHandling()->signIn();

        $this->postJson('/api/settings/company/logo', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);       
   }

   /** @test */
   function a_user_may_add_a_logo_to_their_company()
   {
        $this->signIn();

        Storage::fake('public');

        $this->postJson('/api/settings/company/logo', [
            'image' => $file = UploadedFile::fake()->image('logo.jpg')       
        ]);    
           
        $this->assertEquals('logos/' .$file->hashName(), auth()->user()->company->getOriginal('logo'));       
        
        Storage::disk('public')->assertExists('logos/' .$file->hashName());
   }
    
} 