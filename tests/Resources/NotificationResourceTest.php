<?php

namespace Piscibus\Notifly\Tests\Resources;

use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Models\NotificationActor;
use Piscibus\Notifly\Models\ReadNotification;
use Piscibus\Notifly\Resources\NotificationJsonResource;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Models\User;

/**
 * Class NotificationResourceTest
 * @package Piscibus\Notifly\Tests\Resources
 */
class NotificationResourceTest extends TestCase
{
    /**
     * @test
     */
    public function test_notifications_to_array()
    {
        $user = factory(User::class)->create();
        $attributes = [
            'owner_type' => $user->getType(),
            'owner_id' => $user->getId(),
        ];
        factory(Notification::class, 30)->create($attributes)->each(function (Notification $item) {
            factory(NotificationActor::class, 5)->create([
                'notification_id' => $item->id,
            ]);
        });
        $notifications = $user->jsonableNotifications;
        $response = NotificationJsonResource::collection($notifications)->response()->getData();
        $item = (array)$response->data[0];
        $keys = [
            'id',
            'verb',
            'time',
            'object',
            'target',
            'icon',
            'actors',
        ];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $item);
        }
    }

    /**
     * @test
     */
    public function test_read_notifications_to_array()
    {
        $user = factory(User::class)->create();
        $attributes = [
            'owner_type' => $user->getType(),
            'owner_id' => $user->getId(),
            'trimmed_actors' => 0,
        ];
        factory(ReadNotification::class, 30)->create($attributes)->each(function (ReadNotification $item) {
            factory(NotificationActor::class, 2)->create([
                'notification_id' => $item->id,
            ]);
        });
        $notifications = $user->jsonableReadNotifications;
        $response = NotificationJsonResource::collection($notifications)->response()->getData();
        $item = (array)$response->data[0];
        $keys = [
            'id',
            'verb',
            'time',
            'object',
            'target',
            'icon',
            'actors',
        ];
        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $item);
        }
    }
}
