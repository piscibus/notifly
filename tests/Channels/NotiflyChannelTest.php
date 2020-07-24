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
     * @test
     */
    public function test_send()
    {
        $user = factory(User::class)->create();
        $actor = factory(User::class)->create();
        $post = factory(Post::class)->create();
        $comment = factory(Comment::class)->create();

        $commentNotification = new CommentNotification($actor, $comment, $post);
        $user->notify($commentNotification);
        
        $expectedNotification = ['id' => $commentNotification->getId()];
        $expectedActor = [
            'notification_id' => $commentNotification->getId(),
            'actor_id' => $actor->getId(),
            'actor_type' => get_class($actor),
        ];

        $this->assertDatabaseHas('notification', $expectedNotification);
        $this->assertDatabaseHas('notification_actor', $expectedActor);
    }
}
