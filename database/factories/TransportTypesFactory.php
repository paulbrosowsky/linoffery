<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Model;
use App\TransportType;
use Faker\Generator as Faker;

$factory->define(TransportType::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'subtitle' => null,
        'width' => null,
        'depth' => null,
        'height' => null
    ];
});
