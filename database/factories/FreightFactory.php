<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Freight;


$factory->define(Freight::class, function(Faker $faker){    
    return [
        'tender_id'=> function(){
            return factory('App\Tender')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'pallet' => $faker->randomElement(['EPAL', 'Gitterbox', 'Sonder']),
        'weight' => $faker->randomNumber(3),
        'width' => $faker->randomNumber(3),
        'length' => $faker->randomNumber(3),
        'height' => $faker->randomNumber(3),        
    ];
});
  