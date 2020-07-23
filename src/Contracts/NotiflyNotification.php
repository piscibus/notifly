<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyNotification
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyNotification
{
    public function getVerb(): string;

    public function getActor(): MorphAble;

    public function getObject(): MorphAble;

    public function getTarget(): MorphAble;
}
