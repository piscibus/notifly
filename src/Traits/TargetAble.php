<?php


namespace Piscibus\Notifly\Traits;

trait TargetAble
{
    /**
     * @inheritDoc
     */
    public function getTargetId()
    {
        $key = $this->getKeyName();

        return $this->$key;
    }
}
