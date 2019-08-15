<?php

namespace Tests\Feature;

use App\Order;
use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewOrderTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function guests_can_not_view_orders()
    {
        $this->withExceptionHandling();
        $this->getJson('api/orders')->assertStatus(401);
        $this->getJson('api/orders/1')->assertStatus(401);
    }

    /** @test */
    function users_can_view_all_orders_where_they_involved_in()
    {
        $user = create('App\User');
        $orderAsTenderer = create('App\Order', ['tenderer_id' => $user->id]);
        $orderAsCarrirer = create('App\Order', ['carrier_id' => $user->id]);
        create('App\Order');

        $this->assertCount(3, Order::all());

        $this->signIn();
        $response = $this->getJson('api/orders')->json();
        $this->assertEmpty($response);

        $this->signIn($user);
        $response = $this->getJson('api/orders')->json();
        
        $this->assertCount(2, $response);
        $this->assertEquals($user->id, $orderAsTenderer->tenderer_id);
        $this->assertEquals($user->id, $orderAsCarrirer->carrier_id);
    }

    /** @test */
    function only_users_can_view_order_where_they_involved_in()
    {
        $tenderer = create('App\User');
        $carrier = create('App\User');
        $order = create('App\Order', [
            'tenderer_id' => $tenderer->id,
            'carrier_id' => $carrier->id
        ]);
    
        $this->signIn()->withExceptionHandling();
        $this->getJson('api/orders/'.$order->id)->assertStatus(403);

        $this->signIn($tenderer);
        $response = $this->getJson('api/orders/'.$order->id)->json();        
        $this->assertEquals($tenderer->id, $response['tenderer_id']);

        $this->signIn($carrier);
        $response = $this->getJson('api/orders/'.$order->id)->json();        
        $this->assertEquals($carrier->id, $response['carrier_id']);
    }

    
}