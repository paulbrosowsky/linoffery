<?php


namespace Tests\Unit;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends PassportTestCase
{
    use RefreshDatabase;
    
    protected $comment;

    public function setUp():void
    {
       parent::setUp();
       
       $this->comment = create('App\Comment');
    }

    /** @test */
    function is_belongs_to_a_user()
    {
        $this->assertInstanceOf('App\User', $this->comment->user);
    }

    /** @test */
    function is_belongs_to_a_company()
    {
        $this->assertInstanceOf('App\Company', $this->comment->company);
    }
    
}