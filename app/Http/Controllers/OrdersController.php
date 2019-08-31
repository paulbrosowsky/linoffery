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
        
        $file= storage_path('app/public/pdf/orders/order-'.$order->id.'.pdf');
        
        if(!Storage::disk('public')->exists('pdf/orders/order-'.$order->id.'.pdf')){
            $order->makePdf();
        }  

        return response()->download($file);
    }
}
