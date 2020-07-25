<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface Morphable
 * @package Piscibus\Notifly\Contracts
 */
interface Morphable
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