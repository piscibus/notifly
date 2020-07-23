<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyChannel
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyChannel
{
    /**
     * @param MorphAble $notiflyAble
     * @param NotiflyNotification $notification
     * @return void
     */
    public function send(MorphAble $notiflyAble, NotiflyNotification $notification): void;
}
