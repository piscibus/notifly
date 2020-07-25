<?php


namespace Piscibus\Notifly\Channels;

use Piscibus\Notifly\Contracts\Morphable as Notifiable;
use Piscibus\Notifly\Contracts\NotiflyChannelContract;
use Piscibus\Notifly\Contracts\NotiflyNotificationContract as Notification;
use Piscibus\Notifly\Models\Notification as NotificationModel;
use Piscibus\Notifly\Models\ReadNotification;

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
        $preCreated = $this->getPreCreatedItem($notifiable, $notification);
        if ($preCreated) {
            $item = $this->pullNotificationUp($preCreated);
        } else {
            $item = $this->createFreshNotification($notifiable, $notification);
        }
        $item->addActor($notification->getActor());
    }

    /**
     * @param Notifiable $notifiable
     * @param Notification $notification
     * @return NotificationModel|null
     */
    public function getPreCreatedItem(Notifiable $notifiable, Notification $notification): ?NotificationModel
    {
        $readItem = ReadNotification::findByNotification($notifiable, $notification);
        if ($readItem) {
            $item = $readItem->markAsUnRead();
        } else {
            $item = NotificationModel::findByNotification($notifiable, $notification);
        }

        return $item;
    }

    /**
     * @param NotificationModel $notification
     * @return NotificationModel
     */
    private function pullNotificationUp(NotificationModel $notification): NotificationModel
    {
        return $notification->pullUp();
    }

    /**
     * @param Notifiable $notifiable
     * @param Notification $notification
     * @return NotificationModel
     */
    private function createFreshNotification(Notifiable $notifiable, Notification $notification): NotificationModel
    {
        $item = NotificationModel::init($notifiable, $notification);
        $item->save();

        return $item;
    }
}
