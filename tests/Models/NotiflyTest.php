<?php

namespace Piscibus\Notifly\Tests\Models;

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
        $attributes = ['verb' => 'foo', 'notifly_type' => '', 'notifly_id' => 0];
        $notification = Notifly::create($attributes);
        $uuid = Uuid::fromString($notification->getId());
        $this->assertInstanceOf(UuidInterface::class, $uuid);
    }

    /**
     * @test
     */
    public function test_notiflyable_can_access_notifications()
    {
        $user = factory(User::class)->create();
        $notifications = $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo'])->toArray()
        );
        $this->assertEquals($notifications->count(), $user->notifications->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_read_notifications()
    {
        $user = factory(User::class)->create();
        $readNotifications = $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo', 'read_at' => now()])->toArray()
        );
        $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo'])->toArray()
        );
        $this->assertEquals($readNotifications->count(), $user->readNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_unread_notifications()
    {
        $user = factory(User::class)->create();
        $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo', 'read_at' => now()])->toArray()
        );
        $unreadNotifications = $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo'])->toArray()
        );
        $this->assertEquals($unreadNotifications->count(), $user->unreadNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_seen_notifications()
    {
        $user = factory(User::class)->create();
        $seenNotifications = $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo', 'seen_at' => now()])->toArray()
        );
        $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo'])->toArray()
        );
        $this->assertEquals($seenNotifications->count(), $user->seenNotifications()->count());
    }

    /**
     * @test
     */
    public function test_notiflyable_can_get_unseen_notifications()
    {
        $user = factory(User::class)->create();
        $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo', 'seen_at' => now()])->toArray()
        );
        $unseenNotifications = $user->notifications()->createMany(
            factory(Notifly::class, rand(1, 10))->make(['verb' => 'foo'])->toArray()
        );
        $this->assertEquals($unseenNotifications->count(), $user->unseenNotificiations()->count());
    }
}
