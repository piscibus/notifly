<?php


namespace Piscibus\Notifly\Notifications;

use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Str;
use Piscibus\Notifly\Contracts\NotiflyNotificationContract;
use Piscibus\Notifly\Contracts\Transformable;

class Notification extends BaseNotification implements NotiflyNotificationContract
{
    /**
     * @var Transformable
     */
    protected $actor;

    /**
     * @var string
     */
    protected $verb = '';

    /**
     * @var Transformable
     */
    protected $object;

    /**
     * @var Transformable
     */
    protected $target;

    /**
     * CommentNotification constructor.
     * @param Transformable $actor
     * @param Transformable $object
     * @param Transformable $target
     */
    public function __construct(Transformable $actor, Transformable $object, Transformable $target)
    {
        $this->id = Str::orderedUuid();
        $this->actor = $actor;
        $this->object = $object;
        $this->target = $target;
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
        //TODO: validate verb
        return $this->verb;
    }

    /**
     * @return Transformable
     */
    public function getActor(): Transformable
    {
        return $this->actor;
    }

    /**
     * @return Transformable
     */
    public function getTarget(): Transformable
    {
        return $this->target;
    }


    /**
     * @return Transformable
     */
    public function getObject(): Transformable
    {
        return $this->object;
    }
}
