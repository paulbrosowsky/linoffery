<?php

namespace App\Events;

use App\Offer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class OfferAccepted
{
    use Dispatchable, SerializesModels;

    public $offer;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Offer $offer)
    {     
        $this->offer = $offer;
    }

   
}
