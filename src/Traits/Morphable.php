<?php


namespace Piscibus\Notifly\Traits;

trait Morphable
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
}
