<?php

namespace Piscibus\Notifly\Tests\Models;

use Illuminate\Support\Collection;
use Piscibus\Notifly\Models\Notifly;
use Piscibus\Notifly\Tests\TestCase;
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
        $notification = factory(Notifly::class)->create();
        $uuid = Uuid::fromString($notification->getId());
        $this->assertInstanceOf(UuidInterface::class, $uuid);
    }

    /**
     * @test
     */
    public function test_notiflyable_can_access_notifications()
    {
        /** @var User $user */
        $user = factory(User::class)->create();
        $notifications = factory(Notifly::class, rand(1, 10))->make()->toArray();
        /** @var Collection $notifications */
        $notifications = $user->notifications()->createMany($notifications);
        $this->assertEquals($notifications->count(), $user->notifications->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_read_notifications()
    {
        $user = factory(User::class)->create();
        $notifications = factory(Notifly::class, rand(1, 10))->make(['read_at' => now()])->toArray();
        /** @var Collection $readNotifications */
        $readNotifications = $user->notifications()->createMany($notifications);
        $notifications = factory(Notifly::class, rand(1, 10))->make()->toArray();
        $user->notifications()->createMany($notifications);
        $this->assertEquals($readNotifications->count(), $user->readNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_unread_notifications()
    {
        $user = factory(User::class)->create();
        $notifications = factory(Notifly::class, rand(1, 10))->make(['read_at' => now()])->toArray();
        $user->notifications()->createMany($notifications);
        $notifications = factory(Notifly::class, rand(1, 10))->make()->toArray();
        /** @var Collection $unreadNotifications */
        $unreadNotifications = $user->notifications()->createMany($notifications);
        $this->assertEquals($unreadNotifications->count(), $user->unreadNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_seen_notifications()
    {
        $user = factory(User::class)->create();
        $notifications = factory(Notifly::class, rand(1, 10))->make(['seen_at' => now()])->toArray();
        /** @var Collection $seenNotifications */
        $seenNotifications = $user->notifications()->createMany($notifications);
        $user->notifications()->createMany(factory(Notifly::class, rand(1, 10))->make()->toArray());
        $this->assertEquals($seenNotifications->count(), $user->seenNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_unseen_notifications()
    {
        $user = factory(User::class)->create();
        $notifications = factory(Notifly::class, rand(1, 10))->make(['seen_at' => now()])->toArray();
        $user->notifications()->createMany($notifications);
        $notifications = factory(Notifly::class, rand(1, 10))->make()->toArray();
        /** @var Collection $unseenNotifications */
        $unseenNotifications = $user->notifications()->createMany($notifications);
        $this->assertEquals($unseenNotifications->count(), $user->unseenNotificiations()->count());
    }
}
