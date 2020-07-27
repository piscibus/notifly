<?php


namespace Piscibus\Notifly\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Piscibus\Notifly\Traits\NotificationModelTrait;
use RuntimeException;

/**
 * Class ReadNotification
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
 */
class ReadNotification extends Model
{
    use NotificationModelTrait;

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
     * @return Notification
     */
    public function markAsUnRead(): Notification
    {
        $this->forceFill(['seen_at' => null]);

        try {
            $this->delete();
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }

        return Notification::fromReadNotification($this);
    }
}
