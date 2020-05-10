<?php

namespace Tests\Unit ;

use App\Jobs\AcceptOfferJob;
use App\Notifications\OfferWasAccepted;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class NotificationTest extends PassportTestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        Storage::fake();
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
        $offer = create('App\Offer', ['tender_id' => $tender->id]);

        create('App\Offer', [
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
        ], 3);

        AcceptOfferJob::dispatch($offer);
        
        $this->assertCount(1, auth()->user()->unreadNotifications);
    }

    /** @test */
    function order_participants_recieve_notifications_if_offer_have_been_accepted()
    {      
        $offer = create('App\Offer', [
            'user_id' => auth()->id(),          
        ]);        

        AcceptOfferJob::dispatch($offer);    
        
        $this->assertCount(1, $offer->order->tenderer->unreadNotifications);
        $this->assertCount(1, $offer->order->carrier->unreadNotifications);       
    }

    /** @test */
    function order_participants_recieve_emails_if_offer_have_been_accepted()
    {
        Notification::fake();
       
        $offer = create('App\Offer', [
            'user_id' => auth()->id(),          
        ]);      

        AcceptOfferJob::dispatch($offer);

        Notification::assertSentTo($offer->order->tenderer, OfferWasAccepted::class);
        Notification::assertSentTo(
            $offer->order->carrier, 
            OfferWasAccepted::class, 
            function($notifiaction){                
                return $notifiaction->toMail(auth()->user())->attachments > 0;
        });
        
    }

    /** @test */
    function offers_recieve_notification_if_tender_was_cloned()
    {
        $tender = create('App\Tender');
        create('App\Offer', [
            'user_id' => auth()->id(),
            'tender_id' => $tender->id,
        ]);
        
        $tender->clone();
                 
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