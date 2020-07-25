<?php


namespace Piscibus\Notifly\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Interface Transformable
 * @package Piscibus\Notifly\Contracts
 */
interface Transformable extends Morphable
{
    /**
     * @return JsonResource
     */
    public function getTransformer(): JsonResource;
}
