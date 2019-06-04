<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use DavideCasiraghi\LaravelEventsCalendar\Models\EventCategory;

$factory->define(EventCategory::class, function (Faker $faker) {
    $name = $faker->name;
    $slug = Str::slug($name, '-');

    return [
        'name:en' => $name,
        'slug:en' => $slug,
    ];
});
