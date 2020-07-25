<?php


namespace Piscibus\Notifly\Channels;

use Piscibus\Notifly\Contracts\Morphable as Notifiable;
use Piscibus\Notifly\Contracts\NotiflyChannelContract;
use Piscibus\Notifly\Contracts\NotiflyNotificationContract as Notification;
use Piscibus\Notifly\Models\Notification as NotificationModel;

/**
 * Class NotiflyChannel
 * @package Piscibus\Notifly\Channels
 */
class NotiflyChannel implements NotiflyChannelContract
{
    /**
     * @inheritDoc
     */
    public function send(Notifiable $notifiable, Notification $notification): void
    {
        $item = NotificationModel::findByNotification($notifiable, $notification);

        if ($item) {
            $item->pullUp();
        } else {
            $item = NotificationModel::init($notifiable, $notification);
            $item->save();
        }
        $item->addActor($notification->getActor());
    }
}
