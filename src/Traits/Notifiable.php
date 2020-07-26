<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Notifications\RoutesNotifications;

/**
 * Trait Notifiable
 * @package Piscibus\Notifly\Traits
 */
trait Notifiable
{
    use HasDatabaseNotifications, RoutesNotifications, HasJsonableNotifications;
}
