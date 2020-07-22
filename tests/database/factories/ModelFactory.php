<?php
/* @var Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator;
use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestModels\Activity;
use Piscibus\Notifly\Tests\TestModels\Comment;
use Piscibus\Notifly\Tests\TestModels\Like;
use Piscibus\Notifly\Tests\TestModels\ObjectExample;
use Piscibus\Notifly\Tests\TestModels\TargetExample;
use Piscibus\Notifly\Tests\TestModels\User;

$factory->define(User::class, function (Generator $faker) {
    return [];
});

$factory->define(Notifly::class, function (Generator $faker) {
    return [];
});

$factory->define(ObjectExample::class, function (Generator $faker) {
    return [];
});

$factory->define(TargetExample::class, function (Generator $faker) {
    return [];
});

$factory->define(Activity::class, function (Generator $faker) {
    return [];
});

$factory->define(Comment::class, function (Generator $faker) {
    return [];
});

$factory->define(Like::class, function (Generator $faker) {
    return [];
});
