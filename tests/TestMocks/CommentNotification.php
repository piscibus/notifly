<?php


namespace Piscibus\Notifly\Tests\TestMocks;

use Piscibus\Notifly\Channels\NotiflyChannel;
use Piscibus\Notifly\Notifications\Notification;

class CommentNotification extends Notification
{
    /**
     * @var string
     */
    protected $verb = 'comment';

    /**
     * @return array
     */
    public function via(): array
    {
        return [NotiflyChannel::class];
    }
}
