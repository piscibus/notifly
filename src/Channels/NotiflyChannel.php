<?php


namespace Piscibus\Notifly\Channels;

use Piscibus\Notifly\Contracts\MorphAble;
use Piscibus\Notifly\Contracts\NotiflyChannel as ChannelContract;
use Piscibus\Notifly\Contracts\NotiflyNotification;
use Piscibus\Notifly\Models\Notifly;

/**
 * Class NotiflyChannel
 * @package Piscibus\Notifly\Channels
 */
class NotiflyChannel implements ChannelContract
{
    /**
     * @inheritDoc
     */
    public function send(MorphAble $notiflyAble, NotiflyNotification $notification): void
    {
        $item = Notifly::init($notiflyAble, $notification);
        $item->save();
    }
}
