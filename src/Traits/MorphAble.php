<?php


namespace Piscibus\Notifly\Traits;

trait MorphAble
{
    /**
     * @return string
     */
    public function getId(): string
    {
        $key = $this->getKeyName();

        return (string)$this->$key;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return get_class($this);
    }
}
