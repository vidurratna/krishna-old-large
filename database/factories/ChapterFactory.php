<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Chapter;
use Faker\Generator as Faker;

$factory->define(Chapter::class, function (Faker $faker) {
    return [
        'name' => $faker->city,
        'country' => $faker->country,
        'region' => $faker->state,
        'address' => $faker->address,
        'founded' => $faker->dateTimeThisCentury,
        'subdomain' => $faker->domainWord,
    ];
});
