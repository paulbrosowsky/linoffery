<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

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

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return $order;
    }
}
