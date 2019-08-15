<?php

namespace Tests\Feature;

use App\Offer;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CancelOffersTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $offer;
    protected $user;
    
    public function setUp():void
    {
        parent::setup();

        $this->withExceptionHandling();

        $this->user = create('App\User');
        $this->offer = create('App\Offer', ['user_id' => $this->user->id]);
    }
    
    /** @test */
    function not_owners_can_not_cancel_offers()
    {
        $this->signIn();
        $this->deleteJson('/api/offers/'.$this->offer->id.'/destroy')
            ->assertStatus(403);        
    }

     /** @test */
    function owners_can_cancel_thier_offers()
    {
        $this->signIn($this->user);

        $this->assertCount(1, Offer::all());

        $this->deleteJson('/api/offers/'.$this->offer->id.'/destroy');
        
        $this->assertEmpty(Offer::all());
    }
}