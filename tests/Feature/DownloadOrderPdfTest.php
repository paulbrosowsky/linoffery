<?php

namespace Tests\Featue ;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class DownloadOrderPdfTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function unautorized_users_may_not_download_pdf()
    {        
        $order = create('App\Order');

        $this->signIn()->withExceptionHandling();

        $this->getJson('/api/orders/'.$order->id.'/pdf')
            ->assertStatus(403);        
    }

    /** @test */
    function participans_may_download_orders_pdf()
    {
        // Storage::fake(); 

        $order = create('App\Order');
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

        $this->signIn($order->tenderer);
        
        $this->getJson('/api/orders/'.$order->id.'/pdf')->assertStatus(200);            
    }
    
}