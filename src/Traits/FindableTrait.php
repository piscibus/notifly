<?php


namespace Piscibus\Notifly\Traits;

use Piscibus\Notifly\Contracts\MorphableInterface as Entity;
use Piscibus\Notifly\Contracts\NotiflyNotificationInterface;

/**
 * Trait FindableTrait
 * @package Piscibus\Notifly\Traits
 */
trait FindableTrait
{
    /**
     * @param Entity $owner
     * @param NotiflyNotificationInterface $notification
     * @return static|null
     */
    public static function findByNotification(Entity $owner, NotiflyNotificationInterface $notification): ?self
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
