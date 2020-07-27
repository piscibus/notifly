<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyChannelInterface
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyChannelInterface
{
    /**
     * Send the given notification.
     *
     * @param MorphableInterface $notifiable
     * @param NotiflyNotificationInterface $notification
     * @return void
     */
    public function send(MorphableInterface $notifiable, NotiflyNotificationInterface $notification): void;
}
