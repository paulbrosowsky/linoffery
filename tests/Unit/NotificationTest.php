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