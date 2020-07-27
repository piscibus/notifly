<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Http\Resources\Json\JsonResource;
use Piscibus\Notifly\Resources\CommonResource;

trait Notifly
{
    /**
     * @inheritDoc
     */
    public function getId(): string
    {
        $key = $this->getKeyName();

        return $this->$key;
    }

    /**
     * @inheritDoc
     */
    public function getType(): string
    {
        return get_class($this);
    }

    /**
     * @return JsonResource
     */
    public function getTransformer(): JsonResource
    {
        return new CommonResource($this);
    }
}
