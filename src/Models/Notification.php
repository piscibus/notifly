<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Piscibus\Notifly\Contracts\Morphable as Entity;
use Piscibus\Notifly\Contracts\NotiflyNotificationContract;
use Piscibus\Notifly\Contracts\Transformable;

/**
 * Class Notification
 * @property string id
 * @property string verb
 * @property string owner_type
 * @property string owner_id
 * @property string object_type
 * @property string object_id
 * @property string target_type
 * @property string target_id
 * @property Carbon created_at
 * @package Piscibus\Notifly\Models
 */
class Notification extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'notification';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @param Entity $owner
     * @param NotiflyNotificationContract $notification
     * @return static
     */
    public static function init(Entity $owner, NotiflyNotificationContract $notification): self
    {
        $item = new self();
        $item->id = $notification->getId();
        $item->verb = $notification->getVerb();
        $item->created_at = $item->freshTimestamp();

        $item->owner_type = $owner->getType();
        $item->owner_id = $owner->getId();

        $item->object_type = $notification->getObject()->getType();
        $item->object_id = $notification->getObject()->getId();

        $item->target_type = $notification->getTarget()->getType();
        $item->target_id = $notification->getTarget()->getId();

        return $item;
    }

    /**
     * @param Transformable $actor
     * @return Model
     */
    public function addActor(Transformable $actor): Model
    {
        $exists = $this->actors()->find($actor->getId());
        return $exists ? $this->updateActor($exists) : $this->attachActor($actor);
    }

    /**
     * Get notification actors
     */
    public function actors()
    {
        return $this->hasMany(NotificationActor::class)
            ->orderBy('added_on', 'DESC');
    }

    /**
     * @param $exists
     * @return mixed
     */
    private function updateActor(Model $exists)
    {
        $exists->added_on = $this->freshTimestamp();
        $exists->save();
        return $exists;
    }

    /**
     * @param Transformable $actor
     * @return Model
     */
    private function attachActor(Transformable $actor): Model
    {
        $attributes = [
            'actor_type' => $actor->getType(),
            'actor_id' => $actor->getId(),
        ];
        return $this->actors()->create($attributes);
    }
}
