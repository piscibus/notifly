<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface NotiflyNotificationInterface
 * @package Piscibus\Notifly\Contracts
 */
interface NotiflyNotificationInterface
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
     * @return TransformableInterface
     */
    public function getActor(): TransformableInterface;

    /**
     * @return TransformableInterface
     */
    public function getObject(): TransformableInterface;

    /**
     * @return TransformableInterface
     */
    public function getTarget(): TransformableInterface;
}
