<?php

use Faker\Generator as Faker;

$factory->define(App\ShortUrlLog::class, function (Faker $faker) {
    return [
        'short_url_id' => function () {
            return factory('ShortUrl')->create()->id;
        },
        'ip_address' => $faker->ipv4,
    ];
});
