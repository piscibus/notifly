<?php


namespace Piscibus\Notifly\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Interface TransformableInterface
 * @package Piscibus\Notifly\Contracts
 */
interface TransformableInterface extends MorphableInterface
{
    /**
     * @return JsonResource
     */
    public function getTransformer(): JsonResource;
}
