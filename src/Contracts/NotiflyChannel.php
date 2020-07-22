<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyChannel
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyChannel
{
    /**
     * @param NotiflyAble $notiflyAble
     * @param NotiflyNotification $notification
     * @return void
     */
    public function send(NotiflyAble $notiflyAble, NotiflyNotification $notification): void;
}
