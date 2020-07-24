<?php
/* @var Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator;
use Piscibus\Notifly\Tests\TestMocks\Comment;
use Piscibus\Notifly\Tests\TestMocks\Post;
use Piscibus\Notifly\Tests\TestMocks\User;

$factory->define(User::class, function (Generator $faker) {
    return [];
});

$factory->define(Post::class, function (Generator $faker) {
    return [];
});

$factory->define(Comment::class, function (Generator $faker) {
    return [];
});
