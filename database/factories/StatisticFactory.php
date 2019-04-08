<?php

use Faker\Generator as Faker;

$factory->define(App\Statistic::class, function (Faker $faker) {
    $registeredUsersNumber = $faker->numberBetween($min = 0, $max = 10000);
    $organizersNumber = $faker->numberBetween($min = 0, $max = 10000);
    $teachersNumber = $faker->numberBetween($min = 0, $max = 10000);
    $activeEventsNumber = $faker->numberBetween($min = 0, $max = 10000);

    return [
        'registered_users_number' => $registeredUsersNumber,
        'organizers_number' => $organizersNumber,
        'teachers_number' => $teachersNumber,
        'active_events_number' => $activeEventsNumber,
    ];
});
