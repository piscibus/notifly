<?php
/* @var Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator;
use Piscibus\Notifly\Tests\Channels\ObjectExample;
use Piscibus\Notifly\Tests\Channels\TargetExample;
use Piscibus\Notifly\Tests\Channels\User;

$factory->define(User::class, function (Generator $faker) {
    return [];
});

$factory->define(ObjectExample::class, function (Generator $faker) {
    return [];
});

$factory->define(TargetExample::class, function (Generator $faker) {
    return [];
});
