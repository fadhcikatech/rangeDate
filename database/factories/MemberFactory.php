<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\MemberModel;
use Faker\Generator as Faker;

$factory->define(MemberModel::class, function (Faker $faker) {
    return [
        'name' =>$faker->name,
        'phone' =>$faker->e164PhoneNumber,
        'email' => $faker->unique()->safeEmail,
        'alamat' => $faker->alamat,
        'hobby' => $faker->hobby
    ];
});
