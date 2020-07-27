<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface MorphableInterface
 * @package Piscibus\Notifly\Contracts
 */
interface MorphableInterface
{
    /**
     * @return string
     */
    public function getId(): string;

    /**
     * @return string
     */
    public function getType(): string;
}
