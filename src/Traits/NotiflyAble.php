<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Notifications\Notifiable;

trait NotiflyAble
{
    use Notifiable;

    /**
     * @inheritDoc
     */
    public function getNotiflyId()
    {
        $key = $this->getKeyName();
        return $this->$key;
    }
}
