<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface Transformable
 * @package Piscibus\Notifly\Contracts
 */
interface Transformable extends Morphable
{
    /**
     * @return Transformer
     */
    public function getTransformer(): Transformer;
}
