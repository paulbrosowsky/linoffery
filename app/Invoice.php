<?php

namespace App;

use App\Events\InvoiceCreated;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasCustomId, HasPdf;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::created(function($invoice){
            InvoiceCreated::dispatch($invoice);
        });        
    }

    /**
     *  Invoice Belongs To an Order
     * 
     * @return belongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }  
    
     /**
     *  Invoice Belongs To an Company
     * 
     * @return belongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    } 
}
