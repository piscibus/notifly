<?php

namespace Piscibus\Notifly\Tests\Channels;

use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Comment;
use Piscibus\Notifly\Tests\TestMocks\CommentNotification;
use Piscibus\Notifly\Tests\TestMocks\Post;
use Piscibus\Notifly\Tests\TestMocks\User;

/**
 * Class NotiflyChannelTest
 * @package Piscibus\Notifly\Tests\Channels
 */
class NotiflyChannelTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var Post
     */
    private $post;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->post = factory(Post::class)->create();
    }

    /**
     * @test
     */
    public function test_send()
    {
        $actor = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $commentNotification = new CommentNotification($actor, $comment, $this->post);
        $this->user->notify($commentNotification);

        $expectedNotification = ['id' => $commentNotification->getId()];
        $expectedActor = [
            'notification_id' => $commentNotification->getId(),
            'actor_id' => $actor->getId(),
            'actor_type' => get_class($actor),
        ];

        $this->assertDatabaseHas('notification', $expectedNotification);
        $this->assertDatabaseHas('notification_actor', $expectedActor);
    }

    /**
     * @test
     */
    public function test_it_aggregates_actors_on_the_same_notification()
    {
        $actors = factory(User::class, 3)->create();
        $comments = factory(Comment::class, 3)->create();

        for ($i = 0; $i < 3; $i++) {
            $notification = new CommentNotification($actors[$i], $comments[$i], $this->post);
            $this->user->notify($notification);
        }

        $this->assertDatabaseCount('notification', 1);
        $this->assertDatabaseCount('notification_actor', 3);
    }
}
