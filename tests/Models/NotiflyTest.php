<?php

namespace Piscibus\Notifly\Tests\Models;

use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestModels\Activity;
use Piscibus\Notifly\Tests\TestModels\Comment;
use Piscibus\Notifly\Tests\TestModels\CommentNotification;
use Piscibus\Notifly\Tests\TestModels\Like;
use Piscibus\Notifly\Tests\TestModels\LikeNotification;
use Piscibus\Notifly\Tests\TestModels\User;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class NotiflyTest
 * @package Piscibus\Notifly\Tests\Models
 */
class NotiflyTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_has_a_uuid_primary_key()
    {
        $attributes = ['verb' => 'foo', 'notifly_type' => '', 'notifly_id' => 0];
        $notification = Notifly::create($attributes);
        $uuid = Uuid::fromString($notification->getId());
        $this->assertInstanceOf(UuidInterface::class, $uuid);
    }

    /**
     * @test
     */
    public function test_items_can_be_grouped_by_verb_and_target_attributes()
    {
        $user = factory(User::class)->create();
        $actors = factory(User::class, 2)->create();
        $activities = factory(Activity::class, 2)->create();

        $verbs = [];

        foreach ($actors as $actor) {
            foreach ($activities as $activity) {
                $like = factory(Like::class)->create();
                $comment = factory(Comment::class)->create();

                $likeNotification = new LikeNotification($actor, $like, $activity);
                $commentNotification = new CommentNotification($actor, $comment, $activity);

                $verbs[] = $likeNotification->getVerb();
                $verbs[] = $commentNotification->getVerb();

                $user->notify($likeNotification);
                $user->notify($commentNotification);
            }
        }

        $groupBy = ['verb', 'target_type', 'target_id'];
        $results = Notifly::get()->groupBy($groupBy)->toArray();

        $verbs = array_unique($verbs);
        foreach ($verbs as $key) {
            $this->assertArrayHasKey($key, $results);
        }
    }
}
