<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\RoutesNotifications;

/**
 * Trait NotiflyAble
 * @property Collection $notifications
 * @package Piscibus\Notifly\Traits
 */
trait NotiflyAble
{
    use HasDatabaseNotifications, RoutesNotifications;
}
