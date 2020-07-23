<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface MorphAble
 * @package Piscibus\Notifly\Contracts
 */
interface MorphAble
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
