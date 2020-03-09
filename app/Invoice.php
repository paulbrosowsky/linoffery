<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasCustomId, HasPdf;

    protected $guarded = [];

    /**
     *  Invoice Belongs To an Order
     * 
     * @return belongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }   
}
