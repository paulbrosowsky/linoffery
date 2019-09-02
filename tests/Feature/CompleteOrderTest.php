<?php


namespace Tests\Feature;

use Tests\PassportTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompleteOrderTest extends PassportTestCase
{
    use RefreshDatabase;
    
    /** @test */
    function unauthorized_users_may_not_complete_orders()
    {
        $order = create('App\Order');
        $this->signIn()->withExceptionHandling();

        $this->patchJson('api/orders/'.$order->id.'/update')->assertStatus(403);
    }

    /** @test */
    function tenderers_may_set_orders_as_complete()
    {
        $order = create('App\Order');
        $this->signIn($order->tenderer);

        $this->patchJson('api/orders/'.$order->id.'/update');

        $this->assertNotEmpty($order->fresh()->completed_at);
    }
}