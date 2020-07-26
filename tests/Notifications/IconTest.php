<?php

namespace Piscibus\Notifly\Tests\Notifications;

use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Tests\TestCase;
use Piscibus\Notifly\Tests\TestMocks\Notifications\Icons\CommentIcon;

class IconTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('notifly.icons_path', __DIR__ . '/../TestMocks/Notifications/Icons');
        $this->app['config']->set('notifly.icons', [
            'comment' => CommentIcon::class,
        ]);
    }

    /**
     * @test
     */
    public function test_it_can_be_initialized_based_on_notification_verb()
    {
        /** @var Notification $notification */
        $notification = factory(Notification::class)->create(['verb' => 'comment']);
        $icon = $notification->getIcon();
        $this->assertEquals($notification->getObject()->getId(), $icon['width']);
    }
}
