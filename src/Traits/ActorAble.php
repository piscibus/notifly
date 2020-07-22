<?php


namespace Piscibus\Notifly\Traits;

trait ActorAble
{
    /**
     * @inheritDoc
     */
    public function getActorId()
    {
        $key = $this->getKeyName();

        return $this->$key;
    }
}
