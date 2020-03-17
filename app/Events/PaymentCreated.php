<?php

namespace App\Events;

use App\Invoice;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class PaymentCreated
{
    use Dispatchable, SerializesModels;

    public $invoice;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }    
}
