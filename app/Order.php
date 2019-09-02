<?php

namespace App;

use PDF;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    use HasCustomId;
    
    protected $guarded = [];

    protected $with = ['tenderer', 'carrier', 'offer', 'tender'];

     /**
     * A Order belong to a tenderer
     * 
     * @return belondsTo
     */
    public function tenderer()
    {
        return $this->belongsTo(User::class, 'tenderer_id');
    }

    /**
     * A Order belong to a carrier
     * 
     * @return belondsTo
     */
    public function carrier()
    {
        return $this->belongsTo(User::class, 'carrier_id');
    }

    /**
     * A Order belong to a tender
     * 
     * @return belondsTo
     */
    public function tender()
    {
        return $this->belongsTo(Tender::class);
    }

    /**
     * A Order belong to an offer
     * 
     * @return belondsTo
     */
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

   public function makePdf()
   {       
        $pickup = $this->tender->locations->where('type', 'pickup')->first();
        $delivery = $this->tender->locations->where('type', 'delivery')->first();        

        $pdf = PDF::loadView('pdf.order', [
            'order' => $this,
            'tender' => $this->tender,
            'shipper' => $this->tenderer,
            'carrier' => $this->carrier,
            'pickup' => $pickup,
            'delivery' => $delivery,
            'loads' =>  $this->tender->freights,            
        ]); 
    
        $dom_pdf = $pdf->getDomPDF();        

        $canvas = $dom_pdf ->get_canvas(); 
        $canvas->page_text(500, 780, __("Page {PAGE_NUM} of {PAGE_COUNT}"), null, 10, array(0, 0, 0));

        Storage::disk('public')->put('pdf/orders/'.$this->custom_id.'.pdf', $pdf->output());        
   }
}
