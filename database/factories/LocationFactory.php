<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Location;

$factory->define(Location::class, function($faker){    
    $faker = \Faker\Factory::create('de_DE');

    return [
        'tender_id'=> function(){
            return factory('App\Tender')->create()->id;
        },
        'type' => $faker->randomElement(['delivery', 'pickup']),
        'address' => $faker->address,
        'city' => $faker->city, 
        'country' => $faker->country,         
        'lat' => $faker->latitude($min = 47, $max = 54),
        'lng' => $faker->longitude($min = 6, $max = 15),
        'latency' => $faker->randomDigit,
        'earliest_date' => Carbon::now(),
        'latest_date' => Carbon::now()->addWeeks(1), 
        'loading' => $faker -> boolean(),
        'loading_start' => '12:00',
        'loading_end' => '20:30'
    ];
});
