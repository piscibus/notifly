<?php


namespace Piscibus\Notifly\Traits;

/**
 * Trait HasJsonableNotifications
 * @package Piscibus\Notifly\Traits
 */
trait HasJsonableNotifications
{
    /**
     * @return mixed
     */
    public function jsonableNotifications()
    {
        return $this->notifications()->with('jsonableActors');
    }

    /**
     * @return mixed
     */
    public function jsonableReadNotifications()
    {
        return $this->readNotifications()->with('jsonableActors');
    }
}
