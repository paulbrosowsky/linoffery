<?php

namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;

class ViewInvoicesTest extends PassportTestCase
{
    use RefreshDatabase;

    protected $invoice;
    protected $order;

    public function setUp():void
    {
        parent::setUp();

        $this->signIn();

        $this->order = create('App\Order', [ 'tenderer_id' => auth()->id()]);
        $this->invoice = create('App\Invoice', [
            'order_id' => $this->order->id,
            'company_id' => auth()->user()->company->id
        ]);
    }
    
    /** @test */
    function users_may_view_own_invoices()
    { 
        $this->getJson('api/invoices')->assertJsonFragment([
            'custom_id' => $this->invoice->custom_id
        ]);
    }    

    /** @test */
    function users_may_download_invoice_pdf()
    {            
        // Create PDF with PlaceHolders
        $path = $this->invoice->createPdf('layout', 'data');
        $this->invoice->update(['pdf_url' => $path]);

        $this->getJson("api/invoices/{$this->invoice->id}/download")->assertStatus(200);
    }

    /** @test */
    function unathorized_users_may_not_download_invoice_pdfs()
    {
        $this->signIn();

        $path = $this->invoice->createPdf('layout', 'data');
        $this->invoice->update(['pdf_url' => $path]);

        $this->getJson("api/invoices/{$this->invoice->id}/download")->assertStatus(403);
    }


}