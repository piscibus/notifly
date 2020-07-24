<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyNotificationContract
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyNotificationContract
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getVerb(): string;

    /**
     * @return Transformable
     */
    public function getActor(): Transformable;

    /**
     * @return Transformable
     */
    public function getObject(): Transformable;

    /**
     * @return Transformable
     */
    public function getTarget(): Transformable;
}
