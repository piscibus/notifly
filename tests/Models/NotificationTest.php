<?php

namespace Piscibus\Notifly\Tests\Models;

use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Models\User;

class NotificationTest extends TestCase
{
    /**
     * @test
     */
    public function test_it_can_mark_notification_as_seen()
    {
        /** @var Notification $notification */
        $notification = factory(Notification::class)->create();
        $notification->markAsSeen();
        $this->assertNotNull($notification->getSeenAt());
    }

    /**
     * @test
     */
    public function test_it_can_mark_notification_as_unseen()
    {
        /** @var Notification $notification */
        $notification = factory(Notification::class)->create(['seen_at' => now()]);
        $notification->markAsUnseen();
        $this->assertNull($notification->getSeenAt());
    }

    /**
     * @test
     */
    public function test_it_can_mark_notification_as_read()
    {
        /** @var Notification $notification */
        $notification = factory(Notification::class)->create()->fresh();
        $readNotification = $notification->markAsRead();

        $this->assertDatabaseMissing('notification', ['id' => $notification->id]);
        $this->assertDatabaseHas('read_notification', ['id' => $notification->id]);
        $this->assertEquals($readNotification->actors, $notification->actors);
    }

    /**
     * @test
     */
    public function test_it_trims_actors()
    {
        /** @var Notification $notification */
        $notification = factory(Notification::class)->create()->fresh();
        $trimmedActors = 3;
        $amount = config('notifly.max_actors_count') + $trimmedActors;
        $actors = factory(User::class, $amount)->create();
        foreach ($actors as $actor) {
            $notification->addActor($actor);
            $notification = $notification->refresh();
        }
        $this->assertEquals($trimmedActors, $notification->actors->count());
    }
}
