<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyChannelContract
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyChannelContract
{
    /**
     * Send the given notification.
     *
     * @param Morphable $notifiable
     * @param NotiflyNotificationContract $notification
     * @return void
     */
    public function send(Morphable $notifiable, NotiflyNotificationContract $notification): void;
}
