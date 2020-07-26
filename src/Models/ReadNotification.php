<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Piscibus\Notifly\Notifications\Icon;
use Piscibus\Notifly\Traits\Findable;

/**
 * Class ReadNotification
 * @package Piscibus\Notifly\Models
 */
class ReadNotification extends Model
{
    use Findable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'read_notification';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @param Notification $notification
     * @return static
     */
    public static function fromNotification(Notification $notification): self
    {
        $item = new self();
        $attributes = $notification->getAttributes();
        unset($attributes['updated_at']);
        $item->forceFill($attributes);
        $item->save();

        return $item;
    }

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
     * Get the notification object
     */
    public function object()
    {
        return $this->morphTo('object');
    }

    /**
     * Get the notification target
     */
    public function target()
    {
        return $this->morphTo('target');
    }

    /**
     * @return Notification
     */
    public function markAsUnRead(): Notification
    {
        $this->forceFill(['seen_at' => null]);
        $this->delete();

        return Notification::fromReadNotification($this);
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @return Carbon
     */
    public function getTime(): Carbon
    {
        return $this->updated_at;
    }

    /**
     * @return mixed
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @return Collection
     */
    public function getTrimmedActors(): Collection
    {
        return $this->jsonableActors;
    }

    /**
     * @return int
     */
    public function getTrimmed(): int
    {
        return $this->trimmed_actors;
    }

    /**
     * @return array
     * @psalm-suppress UndefinedClass
     */
    public function getIcon(): array
    {
        $iconClass = config("notifly.icons.$this->verb");
        if (is_null($iconClass)) {
            return [];
        }
        /** @var Icon $icon */
        $icon = new $iconClass($this->jsonableActors, $this->object, $this->target);

        return $icon->toArray();
    }
}
