<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory;
use Faker\Generator as Faker;

$factory->define(EventCategory::class, function (Faker $faker) {
    $name = $faker->name;
    $slug = Str::slug($name, '-');

    return [
        'name:en' => $name,
        'slug:en' => $slug,
    ];
});
