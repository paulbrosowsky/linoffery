<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Illuminate\Notifications\DatabaseNotification;

$factory->define(DatabaseNotification::class, function (Faker $faker) {
    return [
        'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
        'type' => \App\Notifications\OfferWasCreated::class,
        'notifiable_id' => function () {
            return auth()->id() ?: factory(\App\User::class)->create()->id;
        },
        'notifiable_type' => \App\User::class,
        'data' => ['foo' => 'bar']
    ];
});
