<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;

$factory->define(App\Category::class, function ($faker) {     
    $name = $faker->unique()->word;   
    return [
        'name'=> $name,
        'slug'=>$name,        
        'color'=> $faker->hexcolor, 
    ];
});
