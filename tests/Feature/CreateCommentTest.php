<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends PassportTestCase
{
    use RefreshDatabase;    
     
    /** @test */
    function guest_may_not_create_comment()
    {
        $this->withExceptionHandling();
        $this->postJson('api/profiles/1/comment')->assertStatus(401);
    }

    /** @test */
    function authenticated_users_may_create_comments()
    {
        $this->signIn();
        $company = create('App\Company');

        $this->assertCount(0, $company->comments);

        $this->postJson('api/profiles/'.$company->id.'/comment', [
            'rating' => 4,
            'body' => "Hallo"
        ]);

        $this->assertCount(1, $company->fresh()->comments);
        $this->assertDatabaseHas('comments', ['body' => 'Hallo']);
    }

    /** @test */
    function rating_is_reqired()
    {
        $this->signIn()->withExceptionHandling();
        $company = create('App\Company');

        $response = $this->postJson('api/profiles/'.$company->id.'/comment', [
            'rating' => null,            
        ])->assertStatus(422);

        $errors = $response->json();
        
        $this->assertArrayHasKey('rating', $errors['errors']);   
    }

    /** @test */
    function rating_is_integer()
    {
        $this->signIn()->withExceptionHandling();
        $company = create('App\Company');

        $response = $this->postJson('api/profiles/'.$company->id.'/comment', [
            'rating' => 2.2,            
        ])->assertStatus(422);

        $errors = $response->json();
        
        $this->assertArrayHasKey('rating', $errors['errors']);   
    }

    /** @test */
    function company_members_may_not_create_comments()
    {
        $user = create('App\User');
        $this->signIn($user);

        $this->postJson('api/profiles/'.$user->company->id.'/comment')->assertStatus(403);
    }

    /** @test */
    function users_may_delete_own_comments()
    {
        $user = create('App\User');
        $comment = create('App\Comment', ['user_id' => $user->id]);

        $this->signIn();
        $this->deleteJson('api/comments/'.$comment->id.'/destroy')->assertStatus(403);

        $this->signIn($user);
        $this->deleteJson('api/comments/'.$comment->id.'/destroy')->assertStatus(200);

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }


}