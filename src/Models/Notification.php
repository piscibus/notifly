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
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon seen_at
 * @package Piscibus\Notifly\Models
 * @method Builder where(array $attributes)
 */
class Notification extends Model
{
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
     * @return NotificationActor
     */
    public function addActor(Transformable $actor): NotificationActor
    {
        $attributes = [
            'actor_type' => $actor->getType(),
            'actor_id' => $actor->getId(),
        ];
        /** @var NotificationActor $exists */
        $exists = $this->actors()->where($attributes)->first();

        return $exists ? $exists->pullUp() : $this->attachActor($actor);
    }

    /**
     * Get notification actors
     */
    public function actors()
    {
        return $this->hasMany(NotificationActor::class)
            ->orderBy('updated_at', 'DESC');
    }

    /**
     * @param Transformable $actor
     * @return NotificationActor
     */
    private function attachActor(Transformable $actor): NotificationActor
    {
        $attributes = [
            'actor_type' => $actor->getType(),
            'actor_id' => $actor->getId(),
        ];

        return $this->actors()->create($attributes);
    }

    /**
     * @return $this
     */
    public function pullUp(): self
    {
        $this->forceFill([
            'updated_at' => $this->freshTimestamp(),
            'seen_at' => null,
        ])->save();

        return $this;
    }

    /**
     * Marks notification as unseen
     */
    public function markAsUnseen(): self
    {
        $this->forceFill(['seen_at' => null])->save();

        return $this;
    }

    /**
     * Marks notification as seen
     */
    public function markAsSeen(): self
    {
        if (is_null($this->seen_at)) {
            $this->forceFill(['seen_at' => $this->freshTimestamp()])->save();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getFillable(): array
    {
        return $this->fillable;
    }

    /**
     * @return Carbon|null
     */
    public function getSeenAt(): ?Carbon
    {
        return $this->seen_at;
    }
}
