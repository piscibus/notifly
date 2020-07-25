<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Model;
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
     * @return Notification
     */
    public function markAsUnRead(): Notification
    {
        $this->forceFill(['seen_at' => null]);
        $this->delete();

        return Notification::fromReadNotification($this);
    }
}
