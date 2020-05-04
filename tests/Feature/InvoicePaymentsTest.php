<?php

namespace Tests\Feature;

use App\Events\InvoiceCreated;
use App\Events\PaymentCreated;
use App\Invoice;
use App\Mail\PayInvoiceEmail;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class InvoicePaymentsTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $order;

    public function setUp():void
    {
        parent::setUp();

        Storage::fake('public');
        Mail::fake(); 
        
        $tender = create('App\Tender');  
              
        create('App\Location', [
            'type' => 'pickup',
            'tender_id' => $tender->id
        ]);
        create('App\Location', [
            'type' => 'delivery',
            'tender_id' => $tender->id
        ]);
        create('App\Freight', [            
            'tender_id' => $tender->id
        ]); 

        $this->order = create('App\Offer', [
            'tender_id' => $tender->id            
        ])->accept();        
    }

    /** @test */
    function it_creates_invoice_upon_an_order()
    {        
        $this->assertDatabaseHas('invoices', ['order_id' => $this->order->id]);       
    }

    /** @test */
    function it_creates_a_mollie_payment_upon_an_order()
    {
        $invoice = Invoice::where('order_id', $this->order->id)->first();
        $this->assertEmpty($invoice->fresh()->payment_id);
        $this->assertEmpty($invoice->fresh()->payment_link);

        InvoiceCreated::dispatch($invoice, true);        
        
        $this->assertNotEmpty($invoice->fresh()->payment_id);
        $this->assertNotEmpty($invoice->fresh()->payment_link);
    }

    /** @test */
    function it_creates_invoice_as_pdf()
    {    
        $invoice = Invoice::where('order_id', $this->order->id)->first();          
        PaymentCreated::dispatch($invoice);
        
        Storage::disk('public')->assertExists("pdf/invoices/{$invoice->custom_id}.pdf");        
    }

    /** @test */
    function it_sends_the_invoice_pdf_to_tenderer_via_email()
    {     
        $invoice = Invoice::where('order_id', $this->order->id)->first();   
        
        PaymentCreated::dispatch($invoice);

        Mail::assertQueued(PayInvoiceEmail::class, function($mail){
            return $mail->attachments > 0;
        });             
    }     
}