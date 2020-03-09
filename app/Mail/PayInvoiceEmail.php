<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class PayInvoiceEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        $file = Storage::disk('public')->url($this->invoice->pdf_url);        
        
        return $this->markdown('emails.pay-invoice')
                ->subject(__('Your invoice for mediation order').' '. $this->invoice->order->custom_id)
                ->attach($file);
    }
}
