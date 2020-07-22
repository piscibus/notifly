<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Piscibus\Notifly\Contracts\NotiflyAble;
use Piscibus\Notifly\Contracts\NotiflyNotification;

/**
 * Class Notifly
 * @property string id
 * @property string verb
 * @property string actor_type
 * @property string actor_id
 * @property string object_type
 * @property string object_id
 * @property string notifly_type
 * @property string notifly_id
 * @property string target_type
 * @property string target_id
 *
 * @package Piscibus\Notifly\Models
 * @method static self create(array $attributes)
 */
class Notifly extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'notifly';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'seen_at' => 'string',
        'read_at' => 'string',
    ];

    /**
     * @param NotiflyAble $notiflyAble
     * @param NotiflyNotification $notification
     * @return static
     */
    public static function init(NotiflyAble $notiflyAble, NotiflyNotification $notification): self
    {
        $actor = $notification->getActor();
        $item = new self();
        $item->verb = $notification->getVerb();
        $item->actor_type = get_class($actor);
        $item->actor_id = $notification->getActor()->getActorId();
        $item->object_type = get_class($notification->getObject());
        $item->object_id = $notification->getObject()->getObjectId();
        $item->notifly_type = get_class($notiflyAble);
        $item->notifly_id = $notiflyAble->getNotiflyId();
        $item->target_type = get_class($notification->getTarget());
        $item->target_id = $notification->getTarget()->getTargetId();

        return $item;
    }

    /**
     * Bootstrap the model
     */
    protected static function boot()
    {
        parent::boot();

        // Generate uuid
        static::creating(function (Model $item) {
            $keyName = $item->getKeyName();
            $item->$keyName = (string)Str::orderedUuid();
        });
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}
