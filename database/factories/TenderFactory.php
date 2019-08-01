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

        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'type' => $faker->word,
        'immadiate_price' => $faker->randomFloat(2),
        'min_price' => $faker->randomFloat(2),
        'valid_date' => Carbon::now()->addWeeks(2)
    ];
});

$factory->state(Tender::class, 'from-existing-data', function(Faker $faker){
    return [
        'user_id'=> function(){
            return App\User::all()->random()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'type' => $faker->randomElement(['Schwertransport', 'Kühltransport', 'Standard', 'Lebensmittel']),        
        'immadiate_price' => $faker->randomFloat(2),
        'min_price' => $faker->randomFloat(2),
        'valid_date' => Carbon::now()->addWeeks(2)
    ];
});
