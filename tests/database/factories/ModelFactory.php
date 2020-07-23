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
    /** @var User $notifly */
    $notifly = factory(User::class)->create();
    /** @var User $actor */
    $actor = factory(User::class)->create();
    /** @var TargetExample $target */
    $target = factory(TargetExample::class)->create();
    /** @var ObjectExample $object */
    $object = factory(ObjectExample::class)->create();

    return [
        'notifly_type' => $notifly->getType(),
        'notifly_id' => $notifly->getId(),
        'actor_type' => $actor->getType(),
        'actor_id' => $actor->getId(),
        'target_type' => $target->getType(),
        'target_id' => $target->getId(),
        'object_type' => $object->getType(),
        'object_id' => $object->getId(),
        'verb' => $faker->colorName,
    ];
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
