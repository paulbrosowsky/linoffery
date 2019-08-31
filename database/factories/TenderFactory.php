<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Tender;
use Carbon\Carbon;

$factory->define(Tender::class, function(Faker $faker){  
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },

        'category_id'=> function(){
            return factory('App\Category')->create()->id;
        },

        'title' => $faker->sentence,
        'description' => $faker->paragraph,        
        'max_price' => $faker->numberBetween(200, 10000),
        'immediate_price' => $faker->numberBetween(100, 200),
        'valid_date' => Carbon::now()->addWeeks(2),
        'published_at' => Carbon::now(),        
    ];
});

$factory->state(Tender::class, 'from-existing-data', function(Faker $faker){
    return [
        'user_id'=> function(){
            return App\User::all()->random()->id;
        },

        'category_id'=> function(){
            return App\Category::all()->random()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,              
        'max_price' => $faker->numberBetween(200, 10000),
        'immediate_price' => $faker->numberBetween(100, 200),
        'valid_date' => Carbon::now()->addWeeks(2),
        'published_at' => Carbon::now()        
    ];
});
