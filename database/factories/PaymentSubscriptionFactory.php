<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */


use App\PaymentSubscription;
use Faker\Generator as Faker;

$factory->define(PaymentSubscription::class, function (Faker $faker) {
    return [
        'company_id'=> function(){
            return factory(App\Company::class)->create()->id;
        },        
        'stripe_id' => $faker->md5,
        'plan' => 'main'
    ];
});
