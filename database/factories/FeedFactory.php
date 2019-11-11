<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Feed;
use Faker\Generator as Faker;

$factory->define(Feed::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => "<p>".implode("</p>\n\n<p>", $faker->paragraphs(rand(3,6)))."</p>",
        'category' => 'test',
        'pubDate' => $faker->dateTime($max = 'now', $timezone = null),
        'link' => $faker->url,
    ];
});
