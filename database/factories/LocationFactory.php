<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Carbon\Carbon;
use App\Location;

$factory->define(Location::class, function($faker){
    $date = Carbon::now();
    $faker = \Faker\Factory::create('de_DE');

    return [
        'tender_id'=> function(){
            return factory('App\Tender')->create()->id;
        },
        'type' => $faker->randomElement(['delivery', 'pickup']),
        'address' => $faker->address,        
        'lat' => $faker->latitude($min = 47, $max = 54),
        'lng' => $faker->longitude($min = 6, $max = 15),
        'latency' => $faker->randomDigit,
        'earliest_date' => $date,
        'latest_date' => $date->addWeeks(1), 
        'loading' => $faker -> boolean()
    ];
});
