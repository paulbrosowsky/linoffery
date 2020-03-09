<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhooksController extends Controller
{
    public function index()
    {
        dd('webhook');
        // $payment = Mollie::api()->payments()->create([
        //     'amount' => [
        //         'currency' => 'EUR',
        //         'value' => '10.00'
        //     ],
        //     'description' => 'My first API payment',
        //     'redirectUrl' => 'https://linoffery.com/',
        // ]);  
        
        // $payment = Mollie::api()->payments()->get($payment->id);

        // dd($payment);
        
    }
}
