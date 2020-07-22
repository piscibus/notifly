<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Notifications\RoutesNotifications;

trait NotiflyAble
{
    use HasDatabaseNotifications, RoutesNotifications;

    /**
     * @inheritDoc
     */
    public function getNotiflyId()
    {
        $key = $this->getKeyName();

        return $this->$key;
    }
}
