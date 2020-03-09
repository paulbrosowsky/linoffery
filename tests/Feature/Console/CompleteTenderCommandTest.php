<?php

namespace Tests\Feature\Console;

use App\Notifications\TenderRunOut;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;

class CompleteTenderCommandTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function tender_will_be_seted_as_complete_after_valid_date()
    {
        $tender = create('App\Tender', [
            'valid_date' => now()->subDay()
        ]);
        $this->assertEmpty($tender->comleted_at);

        $this->artisan('linoffery:complete-tender');

        $this->assertNotEmpty($tender->fresh()->completed_at);
    }

    /** @test */
    function tender_owners_recieve_notification_upon_completing_tender()
    {  
        $tender = create('App\Tender', [
            'valid_date' => now()->subDay()
        ]);
        $this->artisan('linoffery:complete-tender');

        $this->assertCount(1, $tender->user->notifications);       
    }


    /** @test */
    function tender_owners_recieve_notification_email_upon_completing_tender()
    { 
        Notification::fake();
        
        $tender = create('App\Tender', [
            'valid_date' => now()->subDay()
        ]);
        $this->artisan('linoffery:complete-tender');

        Notification::assertSentTo($tender->user, TenderRunOut::class);
    }
    
    
    
}