<?php

namespace Piscibus\Notifly\Tests\TestModels;

use Piscibus\Notifly\Tests\TestCase;

class NotiflyChannelTest extends TestCase
{
    /**
     * @test
     */
    public function test_send()
    {
        // Given
        /** @var User $user */
        $user = factory(User::class)->create();
        /** @var User $actor */
        $actor = factory(User::class)->create();
        /** @var ObjectExample $object */
        $object = factory(ObjectExample::class)->create();
        /** @var TargetExample $target */
        $target = factory(TargetExample::class)->create();

        $notification = new NotificationExample($actor, $object, $target);

        // When
        $user->notify($notification);

        // Then
        $this->assertDatabaseHas('notifly', [
            'verb' => $notification->getVerb(),
            'notifly_type' => $user->getType(),
            'notifly_id' => $user->getId(),
        ]);
    }
}
