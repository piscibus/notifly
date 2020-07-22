<?php


namespace Piscibus\Notifly\Traits;

trait ObjectAble
{
    /**
     * @inheritDoc
     */
    public function getObjectId()
    {
        $key = $this->getKeyName();

        return $this->$key;
    }
}
