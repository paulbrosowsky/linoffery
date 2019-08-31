<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine wethet the user can view the order
     * 
     * @param \App\User $user
     * @param \App\Order $order
     * @return mixed
    */
    public function view(User $user, Order $order)
    {    
        return intval($order->tenderer_id) === $user->id || intval($order->carrier_id) === $user->id;    
    }
}
