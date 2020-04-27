<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhooksController extends Controller
{
    /**
     *  Handle Mollie Webhooks
     * 
     * @param Request $request
     */
    public function handle(Request $request)
    {   
        if(!$request->has('id')){
            return;
        }
        
        if(env('APP_ENV') != 'testing'){
            $payment = Mollie::api()->payments()->get($request->id);
        }else{
            $payment= json_decode(json_encode($request->all()), FALSE);
        }        
       
        Invoice::where('payment_id', $payment->id)->update([
            'status' => $payment->status
        ]);
        
    }
}
