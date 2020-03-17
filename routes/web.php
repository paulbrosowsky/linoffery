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

// use App\Events\InvoiceCreated;
// use App\Events\PaymentCreated;
// use App\Notifications\OfferWasAccepted;

// Route::get('/email', function(){

//     $invoice = App\Invoice::where('custom_id', 'IN68673-68204')->first();
    
//     PaymentCreated::dispatch($invoice);
    
// });