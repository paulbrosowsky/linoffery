<?php

namespace Tests\Feature;

use App\Offer;
use App\Order;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

class AcceptOfferTest extends PassportTestCase
{
    use RefreshDatabase;    
    
    protected $tender;
    protected $user;
    protected $offer;
    
    public function setUp():void
    {
        parent::setup();
        
        Storage::fake();   

        $this->user = create('App\User');
        $this->tender = create('App\Tender', ['user_id' => $this->user->id]);   
        $this->offer = create('App\Offer', ['tender_id' => $this->tender->id]);  
        create('App\Location', [
            'type' => 'pickup',
            'tender_id' => $this->tender->id
        ]);
        create('App\Location', [
            'type' => 'delivery',
            'tender_id' => $this->tender->id
        ]);
        create('App\Freight', [            
            'tender_id' => $this->tender->id
        ]);        
    }

    /** @test */
    function not_tender_owners_can_not_accept_tenders()
    {        
        $this->withExceptionHandling();
        $this->signIn();
        $this->acceptOffer()->assertStatus(403);
    }

    /** @test */
    function tender_owners_may_accept_offers()
    {        
        $this->signIn($this->user);
        $this->acceptOffer();

        $this->assertNotEmpty($this->offer->fresh()->accepted_at);
        $this->assertNotEmpty($this->tender->fresh()->completed_at);
    }

    /** @test */
    function new_order_will_be_created_upon_accepted_offer()
    {  
        $this->signIn($this->user);
        $this->acceptOffer();
        
        $order = Order::first();        
        
        $this->assertEquals($this->tender->id, $order->tender_id);
        $this->assertEquals($this->offer->id, $order->offer_id);
        $this->assertEquals($this->user->id, $order->tenderer_id);
    }

    /** @test */
    function all_offers_exept_accepted_will_be_deleted()
    {   
        create('App\Offer', ['tender_id' => $this->tender->id], 3);  
        $this->assertCount(4, Offer::all());

        $this->signIn($this->user);
        $this->acceptOffer();

        $this->assertCount(1, Offer::all());
    }

    /** @test */
    function create_pdf_upon_new_order()
    { 
        $this->signIn($this->user);

        $this->acceptOffer();
        $order = $this->offer->order;        

        Storage::disk('public')->assertExists('/pdf/orders/'.$order->custom_id.'_carrier.pdf');               
    }

    public function acceptOffer()
    {        
        return $this->patchJson('api/offers/'.$this->offer->id.'/update');
    }
}