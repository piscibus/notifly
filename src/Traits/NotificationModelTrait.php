<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Models\NotificationActor;

trait NotificationModelTrait
{
    use FindableTrait, HasNotificationGetters;

    /**
     * Get notification actors
     */
    public function actors()
    {
        return $this->hasMany(NotificationActor::class, 'notification_id')
            ->orderBy('updated_at', 'DESC');
    }

    /**
     * @return mixed
     */
    public function jsonableActors()
    {
        return $this->actors()->with('actor');
    }

    /**
     * Get the notification target
     */
    public function target()
    {
        return $this->morphTo('target');
    }

    /**
     * Get the notification object
     */
    public function object()
    {
        return $this->morphTo('object');
    }
}
