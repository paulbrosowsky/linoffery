<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Offer;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },

        'tender_id'=> function(){
            return factory('App\Tender')->create()->id;
        },

        'price' => $faker->numberBetween(100, 500)
    ];
});

$factory->state(Offer::class, 'from-existing-data', function(Faker $faker){
    return [
        'user_id'=> function(){
            return App\User::all()->random()->id;
        },

        'category_id'=> function(){
            return App\Category::all()->random()->id;
        },

        'price' => $faker->numberBetween(100, 500)        
    ];
});
