<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name'=>'Create Chapter Posts',
        'ident'=>'chapter.posts.store',
        'description'=>'Creating posts for a chapter that a user is asigned too!',
        'active'=>1,
    ];
});
