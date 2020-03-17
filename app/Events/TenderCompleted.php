<?php

namespace App\Events;

use App\Tender;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TenderCompleted
{
    use Dispatchable, SerializesModels;

    public $tender;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tender $tender)
    {        
        $this->tender = $tender;
    }   
}
