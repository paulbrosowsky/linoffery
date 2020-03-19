<?php

namespace Tests\Feature;

use App\Events\InvoiceCreated;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MollieWebhooksTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function invoice_status_updates_regarding_paymemt_webhook_status()
    {
        $payment =[
            'id' => 'tr_mollie_id',
            'status' => 'paid' 
        ];

        $invoice = create('App\Invoice', [
            'payment_id' => $payment['id']
        ]);

        $this->assertEquals($invoice->status, 'open');    

        $this->postJson('api/mollie/webhook', $payment);

        $this->assertEquals($invoice->fresh()->status, 'paid');         
    }
    
}