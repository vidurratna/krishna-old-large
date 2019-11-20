<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => 'Super Admin',
        'ident' => 'superadmin',
        'description' => "An admin that has the power to anything and everything on the app.",
        'active' => '1',
        'level' => '0'
    ];
});
