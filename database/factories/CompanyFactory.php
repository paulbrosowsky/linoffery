<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    $faker = \Faker\Factory::create('at_AT');

    return [        
        'name' => $faker->company,
        'vat' => $faker->vat(false),    
        'address' => $faker->streetAddress,
        'country' =>  $faker->country,
        'city' =>  $faker->city,
        'postcode' =>  $faker->postcode,
        'stripe_id' => $faker->md5,
        'lat' => $faker->latitude($min = 47, $max = 54),
        'lng' => $faker->longitude($min = 6, $max = 15),  
    ];
});


