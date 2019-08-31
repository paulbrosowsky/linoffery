<?php


namespace Tests\Unit ;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTest extends PassportTestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->signIn();
    }
    
    /** @test */
    function tender_owners_recieve_notification_if_new_offer_has_been_made()
    {        
        $tender = create('App\Tender');

        $tender->addOffer([
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
            'price' => 100
        ]);

        $this->assertCount(1, $tender->user->unreadNotifications);
    }

    /** @test */
    function offerer_with_lowest_price_recives_notification_if_he_is_outbid()
    {
        $tender = create('App\Tender');

        $offer = $tender->addOffer([
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
            'price' => 200
        ]);       

        $this->assertEquals($tender->fresh()->lowest_offer, $offer->price);

        $tender->addOffer([
            'user_id' => create('App\User')->id,
            'tender_id' => $tender->id,
            'price' => 100
        ]);

        $this->assertCount(1, auth()->user()->unreadNotifications);
    }

    /** @test */
    function offerers_recieve_notifications_if_tender_is_compeded()
    {
        $tender = create('App\Tender');
        create('App\Offer', [
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
        ], 3);

        $tender -> complete();
        $this->assertCount(1, auth()->user()->unreadNotifications);
    }

    /** @test */
    function offerers_recieve_notifications_if_thier_offer_have_been_accepted()
    {        
        $offer = create('App\Offer', [
            'user_id' => auth()->id(),          
        ]);
        $order = create('App\Order', [
            'tender_id' => $offer->tender->id,
            'offer_id' => $offer->id,
            'carrier_id' => $offer->user_id,
            'tenderer_id' => $offer->tender->user_id
        ]);
        create('App\Location', [
            'type' => 'pickup',
            'tender_id' => $order->tender->id
        ]);
        create('App\Location', [
            'type' => 'delivery',
            'tender_id' => $order->tender->id
        ]);
        create('App\Freight', [            
            'tender_id' => $order->tender->id
        ]);

        $offer->accept($order);

        $this->assertCount(1, auth()->user()->unreadNotifications);
    }

    /** @test */
    function a_user_can_clear_specific_notifications()
    {
        create(DatabaseNotification::class);     

        $this->assertCount(1, auth()->user()->unreadNotifications);

        $notificationId = auth()->user()->unreadNotifications->first()->id;
            
        $this->deleteJson('api/notifications/'.$notificationId);        
        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

     /** @test */
    function a_user_can_clear_all_notifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(1, auth()->user()->unreadNotifications);        
            
        $this->deleteJson('api/notifications');        
        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }

    /** @test */
    function a_user_can_fetch_all_notifications()
    {
        create(DatabaseNotification::class);  
        
        $response = $this->getJson('api/notifications')->json();    
           
        $this->assertCount(1, $response);
    }


    
}