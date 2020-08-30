<?php

use Faker\Generator as Faker;

$factory->define(\App\ShortUrl::class, function (Faker $faker) {
    return [
        'full_url' => $faker->url,
        'token' => \App\ShortUrl::generateUniqueToken(),
    ];
});
