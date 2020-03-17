<?php

namespace App\Events;

use App\Invoice;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class InvoiceCreated
{
    use Dispatchable, SerializesModels;

    public $invoice;
    public $testable;

    /**
     * Create a new event instance.
     * 
     * @param Invoice $invoice
     * @param $testable // use only for Testing
     * @return void
     */
    public function __construct(Invoice $invoice, $testable = false)
    {
        $this->invoice = $invoice;
        $this->testable = $testable;
    }
}
