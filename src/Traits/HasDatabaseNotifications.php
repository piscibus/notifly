<?php


namespace Piscibus\Notifly\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Piscibus\Notifly\Models\Notification;
use Piscibus\Notifly\Models\ReadNotification;

/**
 * Trait HasDatabaseNotifications
 * @package Piscibus\Notifly\Traits
 */
trait HasDatabaseNotifications
{
    /**
     * Get the entity's notifications.
     *
     * @return MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'owner')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Get the entity's read notifications
     *
     * @return MorphMany
     */
    public function readNotifications()
    {
        return $this->morphMany(ReadNotification::class, 'owner')
            ->orderBy('updated_at', 'desc');
    }

    /**
     * Get unseen notifications
     */
    public function unseenNotifications()
    {
        return $this->notifications()->whereNull('seen_at');
    }

    /**
     * Get seen notifications
     */
    public function seenNotifications()
    {
        return $this->notifications()->whereNotNull('seen_at');
    }
}
