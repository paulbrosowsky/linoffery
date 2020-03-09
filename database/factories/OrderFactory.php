<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'tender_id'=> function(){
            return factory('App\Tender')->create()->id;
        },
        'offer_id'=> function(){
            return factory('App\Offer')->create()->id;
        },
        'tenderer_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'carrier_id'=> function(){
            return factory('App\User')->create()->id;
        },        
    ];
});
