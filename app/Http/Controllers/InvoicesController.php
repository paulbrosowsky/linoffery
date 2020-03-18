<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{

    /**
     *  Get all Invoices for auth user
     * 
     * @return Invoice
     */
    public function index()
    {        
        return Invoice::where('company_id', auth()->user()->company->id)
                ->with('order')
                ->orderBy('created_at', 'desc')
                ->get();                
    }   

    /**
     *  Download Invoice PDF
     * 
     * @param Invoice
     * @return File 
     */
    public function download(Invoice $invoice)
    {  
        if($invoice->order->tenderer->id === auth()->id()){
            return Storage::disk('public')->download($invoice->pdf_url);    
        }        
        
        return response()->json(['message' => 'You are not authorized.'], 403);      
    }
      
}
