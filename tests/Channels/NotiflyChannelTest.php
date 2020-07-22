<?php

namespace Piscibus\Notifly\Tests\Channels;

use Piscibus\Notifly\Tests\TestCase;

class NotiflyChannelTest extends TestCase
{
    /**
     * @test
     */
    public function test_send()
    {
        // Given
        $user = factory(User::class)->create();
        $actor = factory(User::class)->create();
        $object = factory(ObjectExample::class)->create();
        $target = factory(TargetExample::class)->create();

        $notification = new NotificationExample($actor, $object, $target);

        // When
        $user->notify($notification);

        // Then
        $this->assertDatabaseHas('notifly', [
            'notifly_type' => get_class($user),
            'notifly_id' => $user->id,
            'verb' => $notification->getVerb(),
        ]);
    }
}
