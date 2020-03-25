<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/{any}', function () {    
    return view('app');
})->where('any', '.*');

// use App\Invoice;
// use App\Mail\PayInvoiceEmail;

// Route::get('/email', function(){

//     $invoice = Invoice::first();
//     $invoice->company->update(['vat' => 'DE12345']);

//     $invoice->createPdf('pdf.invoice', [
//         'receiver' => $invoice->order->tenderer->company,
//         'invoice' => $invoice 
//     ]);   
    
//     return new PayInvoiceEmail($invoice);
    
// });