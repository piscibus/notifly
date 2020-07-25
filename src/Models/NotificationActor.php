<?php


namespace Piscibus\Notifly\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class NotificationActor
 * @package Piscibus\Notifly\Models
 */
class NotificationActor extends Model
{
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'notification_actor';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function (Model $item) {
            $item->id = (string)Str::orderedUuid();
        });
    }

    /**
     * @return $this
     */
    public function pullUp(): self
    {
        $this->forceFill(['updated_at' => $this->freshTimestamp()])->save();

        return $this;
    }
}
