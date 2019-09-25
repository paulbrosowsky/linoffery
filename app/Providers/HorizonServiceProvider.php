<?php

namespace App\Providers;

use Laravel\Horizon\Horizon;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Horizon::auth(function ($request) { 
            $authorized = in_array($request->user()->email, [
                'max.lindemann@linoffery.com',
                'paul.brosowsky@gmail.com',
                'john@example.com'
            ]);

            if ( !$authorized ) {
                throw new UnauthorizedHttpException('Unauthorized');
            }

            return true;
        });

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');
        
        // Horizon::night();
    }  
}
