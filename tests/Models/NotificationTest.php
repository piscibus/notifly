<?php

namespace Piscibus\Notifly\Tests\Models;

use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Tests\TestCase;

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
        $notification = factory(Notification::class)->create();
        $readNotification = $notification->markAsRead();

        $this->assertDatabaseMissing('notification', ['id' => $notification->id]);
        $this->assertDatabaseHas('read_notification', ['id' => $notification->id]);
        $this->assertEquals($readNotification->actors, $notification->actors);
    }
}
