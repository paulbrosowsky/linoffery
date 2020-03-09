<?php

namespace Tests\Feature;

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
        
        $this->order = create('App\Order'); 
    }

    /** @test */
    function it_creates_invoice_and_mollie_payment_upon_an_order()
    {
        $invoice = Invoice::where('order_id', $this->order->id)->first();
        $payment = $this->order->createPayment($invoice);     
        
        $this->assertEquals($invoice->order_id, $this->order->id);
        $this->assertEquals($this->order->cost, $payment['cost']); 
    }

    /** @test */
    function it_creates_invoice_as_pdf()
    {  
        $invoice = Invoice::where('order_id', $this->order->id)->first();  

        Storage::disk('public')->assertExists("pdf/invoices/{$invoice->custom_id}.pdf");        
    }

    /** @test */
    function it_sends_the_invoice_pdf_to_tenderer_via_email()
    {        
        Mail::assertQueued(PayInvoiceEmail::class, function($mail){
            return $mail->attachments > 0;
        });             
    }     
}