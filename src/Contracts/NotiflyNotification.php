<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyNotification
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyNotification
{
    public function getVerb(): string;

    public function getActor(): ActorAble;

    public function getObject(): ObjectAble;

    public function getTarget(): TargetAble;
}
