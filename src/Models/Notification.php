<?php


namespace Piscibus\Notifly\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Piscibus\Notifly\Contracts\MorphableInterface as Entity;
use Piscibus\Notifly\Contracts\NotiflyNotificationInterface;
use Piscibus\Notifly\Contracts\TransformableInterface;
use Piscibus\Notifly\Traits\NotificationModelTrait;
use RuntimeException;

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
 * @property int trimmed_actors
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon seen_at
 * @property mixed object
 * @property mixed target
 * @property Collection jsonableActors
 * @property Collection actors
 * @package Piscibus\Notifly\Models
 * @method Builder where(array $attributes)
 */
class Notification extends Model
{
    use NotificationModelTrait;

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
     * @param NotiflyNotificationInterface $notification
     * @return static
     */
    public static function init(Entity $owner, NotiflyNotificationInterface $notification): self
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
     * @param ReadNotification $notification
     * @return Notification
     */
    public static function fromReadNotification(ReadNotification $notification): self
    {
        $item = new self();
        $attributes = $notification->getAttributes();
        unset($attributes['updated_at']);
        $item->forceFill($attributes);
        $item->save();

        return $item;
    }

    /**
     * @param TransformableInterface $actor
     * @return NotificationActor
     */
    public function addActor(TransformableInterface $actor): NotificationActor
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
     * @param TransformableInterface $actor
     * @return NotificationActor
     */
    private function attachActor(TransformableInterface $actor): NotificationActor
    {
        $attributes = ['actor_type' => $actor->getType(), 'actor_id' => $actor->getId()];

        /** @var NotificationActor $actor */
        $actor = $this->actors()->create($attributes);

        if ($this->shouldTrimActors()) {
            $this->trimActors();
        }

        return $actor;
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
     * @return $this
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
     * @return ReadNotification
     */
    public function markAsRead(): ReadNotification
    {
        $this->forceFill(['seen_at' => $this->freshTimestamp()]);

        try {
            $this->delete();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        return ReadNotification::fromNotification($this);
    }

    /**
     * @return bool
     */
    private function shouldTrimActors(): bool
    {
        $maxActorsCount = config('notifly.max_actors_count');

        return $this->actors->count() > $maxActorsCount;
    }

    /**
     * Trim actors to the max actors count
     */
    private function trimActors(): void
    {
        $this->actors->last()->delete();
        $this->increment('trimmed_actors');
    }
}
