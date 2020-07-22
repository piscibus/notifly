<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Models\Notifly;

/**
 * Trait HasDatabaseNotifications
 * @package Piscibus\Notifly\Traits
 */
trait HasDatabaseNotifications
{
    use \Illuminate\Notifications\HasDatabaseNotifications;

    /**
     * Get the entity's notifications.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->morphMany(Notifly::class, 'notifly')->orderBy('created_at', 'desc');
    }

    /**
     * Get the entity's seen notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function seenNotifications()
    {
        return $this->notifications()->whereNotNull('seen_at');
    }

    /**
     * Get the entity's unseen notifications.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function unseenNotificiations()
    {
        return $this->notifications()->whereNull('seen_at');
    }
}
