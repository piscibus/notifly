<?php

namespace Piscibus\Notifly\Tests\Channels;

use Piscibus\Notifly\Models\NotificationActor;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Models\Comment;
use Piscibus\Notifly\Tests\TestMocks\Models\Post;
use Piscibus\Notifly\Tests\TestMocks\Models\User;
use Piscibus\Notifly\Tests\TestMocks\Notifications\CommentNotification;

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
        $this->app['config']->set('notifly.max_actors_count', 10);
        $actors = factory(User::class, 3)->create();
        $comments = factory(Comment::class, 3)->create();

        for ($i = 0; $i < 3; $i++) {
            $notification = new CommentNotification($actors[$i], $comments[$i], $this->post);
            $this->user->notify($notification);
        }

        $this->assertDatabaseCount('notification', 1);
        $this->assertDatabaseCount('notification_actor', 3);
    }

    /**
     * @test
     */
    public function test_it_pulls_actor_up_if_reacted()
    {
        $actors = factory(User::class, 2)->create();
        $comments = factory(Comment::class, 2)->create();

        $this->user->notify(new CommentNotification($actors[0], $comments[0], $this->post));
        sleep(1);
        $this->user->notify(new CommentNotification($actors[1], $comments[1], $this->post));

        // assert before react
        $topActor = NotificationActor::orderBy('updated_at', 'DESC')->first();
        $this->assertEquals($actors[1]->id, $topActor->actor_id);

        // assert after react
        sleep(1);
        $this->user->notify(new CommentNotification($actors[0], $comments[0], $this->post));
        $topActor = NotificationActor::orderBy('updated_at', 'DESC')->first();
        $this->assertEquals($actors[0]->id, $topActor->actor_id);
    }

    /**
     * @test
     */
    public function test_it_restores_the_read_notification_on_reacting()
    {
        $actor = factory(User::class)->create();
        $comments = factory(Comment::class, 2)->create();
        // send first notification
        $this->user->notify(new CommentNotification($actor, $comments[0], $this->post));
        // mark the first notification as read
        $this->user->notifications->first()->markAsRead();
        // send another notification
        $this->user->notify(new CommentNotification($actor, $comments[0], $this->post));
        $this->assertEquals(1, $this->user->notifications->count());
    }
}
