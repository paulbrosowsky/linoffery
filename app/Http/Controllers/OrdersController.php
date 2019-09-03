<?php

namespace App\Http\Controllers;

use App\Order;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrdersController extends Controller
{

    /**
     *  Get all orders for involved user
     * 
     * @return Order
     */
    public function index()
    {
        return Order::where('tenderer_id', auth()->id())
                    ->orWhere('carrier_id', auth()->id())
                    ->with('tender')
                    ->get();
    }

    /**
     *  View a give Order
     * 
     * @param id
     * @return Order
     */
    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return $order->load('tender');
    }


    /**
     *  Set a given order as completed
     * 
     * @param Order id
     * @return Order
     */
    public function update(Order $order)
    {   
        $this->authorize('update', $order); 
        
        $order->update([ 'completed_at' => now() ]);

        return $order;
    }

    /**
     *  Download order as PDF
     *  
     * @param Order
     * @return Response $file
     */
    public function pdf(Order $order)
    {        
        $this->authorize('view', $order); 

        // $file = Storage::disk('public')->url('/pdf/orders/'.$order->custom_id.'.pdf');
        
        $file= storage_path('app/public/pdf/orders/'.$order->custom_id.'.pdf');
        
        if(!Storage::disk('public')->exists('pdf/orders/'.$order->custom_id.'.pdf')){
            $order->makePdf();
        }  

        return response()->download($file);
    }
}
