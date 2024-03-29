<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;

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
        'password_reset_token' => null,
        'confirmed' => true,
        'newsletters' => true,
        'deleted_at' => null,
        'terms_accepted_at' => Carbon::now(),
        'payment_terms_accepted_at' => Carbon::now()
    ];
});

$factory->state(User::class, 'no-stripe-customer', function(Faker $faker){
    return [
        'company_id'=> function(){
            return factory(App\Company::class)->create(['stripe_id' => NULL])->id;
        },
        
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,               
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'password_reset_token' => null,
        'confirmed' => true     
    ];
});
