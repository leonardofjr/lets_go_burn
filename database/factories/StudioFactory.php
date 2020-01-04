<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\User;
use App\Studio;
use Faker\Generator as Faker;

$factory->define(Studio::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'phone' => $faker->phoneNumber,
        'address' => $faker->streetAddress,
        'city' => $faker->city,
        'postal_code' => $faker->postcode,
        'lat' => $faker->latitude($min = -50, $max = 50),
        'lon' => $faker->longitude($min = -85, $max = 85),
    ];
});
