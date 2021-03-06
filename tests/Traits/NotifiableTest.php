<?php

namespace Piscibus\Notifly\Tests\Traits;

use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Models\ReadNotification;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Models\Comment;
use Piscibus\Notifly\Tests\TestMocks\Models\Post;
use Piscibus\Notifly\Tests\TestMocks\Models\User;
use Piscibus\Notifly\Tests\TestMocks\Notifications\CommentNotification;

class NotifiableTest extends TestCase
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
    public function test_notifiable_can_be_notified()
    {
        $actor = factory(User::class)->create();
        $comment = factory(Comment::class)->create();
        $notification = new CommentNotification($actor, $comment, $this->post);
        $this->user->notify($notification);

        $this->assertDatabaseHas('notification', [
            'id' => $notification->getId(),
            'owner_id' => $this->user->getId(),
        ]);
    }

    /**
     * @test
     */
    public function test_notifiable_can_get_unseen_notifications()
    {
        $amount = 30;
        factory(Notification::class, $amount)->create([
            'owner_type' => $this->user->getType(),
            'owner_id' => $this->user->getId(),
        ]);
        $unseenNotifications = $this->user->unseenNotifications;
        $this->assertEquals($amount, $unseenNotifications->count());
    }

    /**
     * @test
     */
    public function test_notifiable_can_get_seen_notifications()
    {
        $amount = 30;
        factory(Notification::class, $amount)->create([
            'owner_type' => $this->user->getType(),
            'owner_id' => $this->user->getId(),
            'seen_at' => now(),
        ]);
        $seenNotifications = $this->user->seenNotifications;
        $this->assertEquals($amount, $seenNotifications->count());
    }

    /**
     * @test
     */
    public function test_notifiable_can_get_read_notifications()
    {
        $amount = 30;
        factory(ReadNotification::class, $amount)->create([
            'owner_type' => $this->user->getType(),
            'owner_id' => $this->user->getId(),
            'trimmed_actors' => 0,
        ]);
        $readNotifications = $this->user->readNotifications;
        $this->assertEquals($amount, $readNotifications->count());
    }
}
