<?php

namespace App\Events;

use App\Offer;
use App\Tender;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OfferCreated
{
    use Dispatchable, SerializesModels;

    public $tender;
    public $offer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tender $tender, Offer $offer)
    {
        $this->tender = $tender;
        $this->offer = $offer;
    }
    
}
