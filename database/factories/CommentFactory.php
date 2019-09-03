<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },
        'company_id'=> function(){
            return factory('App\Company')->create()->id;
        },

        'rating' => $faker->numberBetween(1, 5),
        'body' => $faker->paragraph(),
    ];
});

$factory->state(Comment::class, 'from-existing-data', function(Faker $faker){
    return [
        'user_id'=> function(){
            return App\User::all()->random()->id;
        },
        'company_id'=> function(){
            return App\Company::all()->random()->id;
        },

        'rating' => $faker->numberBetween(1, 5),
        'body' => $faker->paragraph(),        
    ];
});

