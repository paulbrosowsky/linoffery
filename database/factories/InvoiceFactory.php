<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'company_id'=> function(){
            return factory(App\Company::class)->create()->id;
        },
        'custom_id' => '', 
        'status' => 'open'       
    ];
});
