<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Contracts\ActorAble;
use Piscibus\Notifly\Contracts\ObjectAble;
use Piscibus\Notifly\Contracts\TargetAble;

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
     * @return string|null
     */
    public function getTargetId(): ?string
    {
        return null;
    }

    /**
     * @return ActorAble
     */
    public function getActor(): ActorAble
    {
        return $this->actor;
    }

    /**
     * @return ObjectAble
     */
    public function getObject(): ObjectAble
    {
        return $this->object;
    }

    /**
     * @return TargetAble
     */
    public function getTarget(): TargetAble
    {
        return $this->taget;
    }
}
