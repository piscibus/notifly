<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Builder;
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
 * @property Carbon added_on
 * @property Carbon seen_at
 * @package Piscibus\Notifly\Models
 * @method Builder where(array $attributes)
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
        $item->added_on = $item->freshTimestamp();

        $item->owner_type = $owner->getType();
        $item->owner_id = $owner->getId();

        $item->object_type = $notification->getObject()->getType();
        $item->object_id = $notification->getObject()->getId();

        $item->target_type = $notification->getTarget()->getType();
        $item->target_id = $notification->getTarget()->getId();

        return $item;
    }

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

    /**
     * @param Transformable $actor
     * @return Model
     */
    public function addActor(Transformable $actor): Model
    {
        $attributes = [
            'actor_type' => $actor->getType(),
            'actor_id' => $actor->getId(),
        ];
        $exists = $this->actors()->where($attributes)->first();
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

    /**
     * Pulls notifications to the top of the list
     */
    public function pullUp(): void
    {
        $this->forceFill([
            'added_on' => $this->freshTimestamp(),
            'seen_at' => null,
        ]);
    }

    /**
     * Marks notification as unseen
     */
    public function markAsUnseen(): void
    {
        $this->forceFill(['seen_at' => null])->save();
    }

    /**
     * Marks notification as seen
     */
    public function markAsSeen(): void
    {
        if (is_null($this->seen_at)) {
            $this->forceFill(['seen_at' => $this->freshTimestamp()])->save();
        }
    }
}
