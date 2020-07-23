<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Contracts\MorphAble;

/**
 * Trait NotiflyNotification
 * @package Piscibus\Notifly\Traits
 */
trait NotiflyNotification
{
    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @return MorphAble
     */
    public function getActor(): MorphAble
    {
        return $this->actor;
    }

    /**
     * @return MorphAble
     */
    public function getObject(): MorphAble
    {
        return $this->object;
    }

    /**
     * @return MorphAble
     */
    public function getTarget(): MorphAble
    {
        return $this->target;
    }
}
