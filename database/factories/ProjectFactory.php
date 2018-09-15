<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function (Faker $faker) {
    // $faker->addProvider(new Faker\Provider\Internet($faker));

    return [
        'type' => 'commercial',
        'name' => $faker->name(),
        'subtitle' => $faker->sentence(4),
        'finished_at' => $faker->date(),
        'desc' => $faker->paragraph(),
        'github_url' => $faker->url,
        'live_site_url' => $faker->url,
        'order' => 1
    ];
});
