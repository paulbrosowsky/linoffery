<?php

namespace App;

use App\Mail\PayInvoiceEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

trait Invoiceable
{
    /**
     *  Boot the Model
     */
    protected static function bootInvoiceable()
    {  
        static::created(function($model){            
            $invoice = $model->createInvoice();            
            $model->sendInvoiceEmail($invoice);
        });           
    } 

    /**
     *  Create Invoice and Store as PDF
     * 
     * @return Invoice
     */
    protected function createInvoice()
    {        
        $invoice = Invoice::create([
            'company_id' => $this->tenderer->company->id,
            'order_id' => $this->id, 
            'custom_id' => ''           
        ]);

        $pdfPath = $invoice->createPdf('pdf.invoice', [
            'receiver' => $this->tenderer->company,
            'invoice' => $invoice 
        ]);

        $invoice->update([ 'pdf_url' => $pdfPath ]);
        
        // Create Payment if Not in Testing Mode
        if(env('APP_ENV') != 'testing'){
            $payment = $this->createPayment($invoice);

            $invoice->update([
                'payment_id' => $payment['id'],
                'payment_link' => $payment['link']
            ]);            
        }  
        
        return $invoice;
    }   

    /**
     *  Create Mollie Payment
     * 
     *  @param Invoice $invoice
     * @return Array
     */
    public function createPayment($invoice)
    {                                  
        if(env('APP_ENV') != 'production'){
            $webhookUrl = env('MOLLIE_WEBHOOK');            
        }else{
            $webhookUrl = route('mollie.webhook');          
        }

        $payment = Mollie::api()->payments()->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $this->cost
            ],                                    
            'description' => __('Order') .': '. $this->custom_id.' / '.__('Invoice') .': '. $invoice->custom_id,
            'webhookUrl' => $webhookUrl,
            'redirectUrl' => config('app.url') .'/orders/'. $this->id ,
        ]);  
        
        $payment = Mollie::api()->payments()->get($payment->id);
        
        return [
            'id' => $payment->id,
            'link' => $payment->getCheckoutUrl(),
            'cost' => $payment->amount->value // Only for Testing 
        ];
    }

    /**
     *  Send Payment Information with Invioce-PDF Attached to the Tenderer
     * 
     * @param Invoice $invoice    
     */
    protected function sendInvoiceEmail($invoice)
    {        
        Mail::to($this->tenderer)->send(new PayInvoiceEmail($invoice));
    }
   
}
