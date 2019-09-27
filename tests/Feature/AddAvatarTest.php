<?php
namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Symfony\Component\VarDumper\Exception\ThrowingCasterException;

class AddAvatarTest extends PassportTestCase
{
    use RefreshDatabase;

   /** @test */
   function only_members_can_add_avatars()
   {
        $this->withExceptionHandling();

        $this->postJson('/api/settings/account/avatar')
            ->assertStatus(401);
   }

   /** @test */
   function a_valide_avatar_must_be_provided()
   {
        $this->withExceptionHandling()->signIn();

        $this->postJson('/api/settings/account/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);       
   }

    /** @test */
    function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->postJson('/api/settings/account/avatar', [
            'image' => $file = UploadedFile::fake()->image('avatar.jpg')       
        ]);    

        $this->assertEquals('/storage/avatars/' .$file->hashName(), auth()->user()->avatar);       
            
        Storage::disk('public')->assertExists('avatars/' .$file->hashName());
    }

    /** @test */
    function delete_avatar_in_the_storage_upon_deleting_a_user_account()
    {        
        $company = create('App\Company', [            
            'stripe_id' => NULL,
            'card_brand' => NULL,
            'card_last_four' => NULL
        ]);
        $user = create('App\User', ['company_id' => $company->id]);

        $this->signIn($user);        

        Storage::fake('public');

        $this->postJson('/api/settings/account/avatar', [
            'image' => $file = UploadedFile::fake()->image('avatar.jpg')       
        ]);    

        $this->assertEquals('/storage/avatars/' .$file->hashName(), $user->avatar);       
            
        Storage::disk('public')->assertExists('avatars/' .$file->hashName());

        $user->delete();        
        
        Storage::disk('public')->assertMissing('avatars/' .$file->hashName());
    }
    
} 