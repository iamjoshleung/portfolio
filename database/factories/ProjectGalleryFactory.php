<?php

use Faker\Generator as Faker;

$factory->define(App\ProjectGallery::class, function (Faker $faker) {
    return [
        'project_id' => function() {
            return factory(App\Project::class)->create()->id;
        },
        'file_uri' => 'projects/' . str_random() . '.jpg'
    ];
});
