<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    // /**
    //  *  Add PDF to the invoice
    //  * 
    //  * @param array $payload
    //  */
    // public function addPdf($payload)
    // {
    //     $this->update([
    //         'pdf_url' => $payload['invoice_pdf'],
    //         'hosted_url' => $payload['hosted_invoice_url']
    //     ]);
    // }
}
