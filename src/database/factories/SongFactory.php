<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Song::class, function (Faker $faker) {
    return [
        'title' => $faker->realText(10),
        'image' => '/asset/image/'.$faker->randomDigit,
        'link' => '/asset/song/'.$faker->randomDigit
    ];
});
