<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Cargo;
use App\Location;
use Carbon\Carbon;
use App\Freight;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'company_id'=> function(){
            return factory(App\Company::class)->create()->id;
        },
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,               
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(Cargo::class, function(Faker $faker){
    return [
        'user_id'=> function(){
            return factory('App\User')->create()->id;
        },

        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'type' => $faker->word
    ];
});

$factory->state(Cargo::class, 'from-existing-data', function(Faker $faker){
    return [
        'user_id'=> function(){
            return App\User::all()->random()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'type' => $faker->word
    ];
});

$factory->define(Location::class, function($faker){
    $date = Carbon::now();
    $faker = \Faker\Factory::create('de_DE');

    return [
        'cargo_id'=> function(){
            return factory('App\Cargo')->create()->id;
        },
        'type' => $faker->randomElement(['delivery', 'pickup']),
        'address' => $faker->streetAddress,
        'country' =>  $faker->country,
        'city' =>  $faker->city,
        'zip' =>  $faker->postcode,
        'lat' => $faker->latitude($min = 47, $max = 54),
        'lng' => $faker->longitude($min = 6, $max = 15),
        'latency' => $faker->randomDigit,
        'earliest_date' => $date->isoFormat('DD.MM.YYYY'),
        'latest_date' => $date->addWeeks(1)->isoFormat('DD.MM.YYYY'),        
        'loading' => true,
    ];
});

$factory->define(Freight::class, function(Faker $faker){    
    return [
        'cargo_id'=> function(){
            return factory('App\Cargo')->create()->id;
        },
        'title' => $faker->sentence,
        'description' => $faker->paragraph,
        'pallet' => 'EPAL',
        'weight' => $faker->randomNumber(3),
        'width' => $faker->randomNumber(3),
        'depth' => $faker->randomNumber(3),
        'height' => $faker->randomNumber(3),        
    ];
});
