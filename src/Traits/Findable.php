<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Contracts\Morphable as Entity;
use Piscibus\Notifly\Contracts\NotiflyNotificationContract;

/**
 * Trait Findable
 * @package Piscibus\Notifly\Traits
 */
trait Findable
{
    /**
     * @param Entity $owner
     * @param NotiflyNotificationContract $notification
     * @return static|null
     */
    public static function findByNotification(Entity $owner, NotiflyNotificationContract $notification): ?self
    {
        $model = new static();
        $attributes = [
            'verb' => $notification->getVerb(),
            'owner_id' => $owner->getId(),
            'owner_type' => $owner->getType(),
            'target_type' => $notification->getTarget()->getType(),
            'target_id' => $notification->getTarget()->getId(),
        ];
        /** @var self $item */
        $item = $model->where($attributes)->first();

        return $item;
    }
}
