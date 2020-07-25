<?php
/* @var Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator;
use Illuminate\Support\Str;
use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Models\ReadNotification;
use Piscibus\Notifly\Tests\TestMocks\Models\Comment;
use Piscibus\Notifly\Tests\TestMocks\Models\Post;
use Piscibus\Notifly\Tests\TestMocks\Models\User;

$factory->define(User::class, function (Generator $faker) {
    return [];
});

$factory->define(Post::class, function (Generator $faker) {
    return [];
});

$factory->define(Comment::class, function (Generator $faker) {
    return [];
});

$factory->define(Notification::class, function (Generator $faker) {
    /** @var User $owner */
    $owner = factory(User::class)->create();
    /** @var Comment $object */
    $object = factory(Comment::class)->create();
    /** @var Post $target */
    $target = factory(Post::class)->create();

    return [
        'id' => (string)Str::orderedUuid(),
        'owner_type' => $owner->getType(),
        'owner_id' => $owner->getId(),
        'verb' => $faker->colorName,
        'object_type' => $object->getType(),
        'object_id' => $object->getId(),
        'target_type' => $target->getType(),
        'target_id' => $target->getId(),
    ];
});

$factory->define(ReadNotification::class, function (Generator $faker) {
    /** @var User $owner */
    $owner = factory(User::class)->create();
    /** @var Comment $object */
    $object = factory(Comment::class)->create();
    /** @var Post $target */
    $target = factory(Post::class)->create();

    return [
        'id' => (string)Str::orderedUuid(),
        'owner_type' => $owner->getType(),
        'owner_id' => $owner->getId(),
        'verb' => $faker->colorName,
        'object_type' => $object->getType(),
        'object_id' => $object->getId(),
        'target_type' => $target->getType(),
        'target_id' => $target->getId(),
        'seen_at' => now(),
    ];
});
