<?php


namespace Piscibus\Notifly\Contracts;

/**
 * Interface Transformer
 * @package Piscibus\Notifly\Contracts
 */
interface Transformer
{
    /**
     * @param Transformable $transformable
     * @return array
     */
    public function transform(Transformable $transformable): array;
}
