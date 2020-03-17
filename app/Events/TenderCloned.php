<?php

namespace App\Events;

use App\Tender;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TenderCloned
{
    use Dispatchable, SerializesModels;

    public $original;
    public $clone;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Tender $original, Tender $clone)
    {
        $this->original = $original;
        $this->clone = $clone;
    }
}
