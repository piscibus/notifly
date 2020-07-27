<?php


namespace Piscibus\Notifly\Notifications;

use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Support\Str;
use Piscibus\Notifly\Contracts\NotiflyNotificationInterface;
use Piscibus\Notifly\Contracts\TransformableInterface;

/**
 * Class Notification
 * @package Piscibus\Notifly\Notifications
 */
abstract class Notification extends BaseNotification implements NotiflyNotificationInterface
{
    /**
     * @var TransformableInterface
     */
    protected $actor;

    /**
     * @var string
     */
    protected $verb = '';

    /**
     * @var TransformableInterface
     */
    protected $object;

    /**
     * @var TransformableInterface
     */
    protected $target;

    /**
     * CommentNotification constructor.
     * @param TransformableInterface $actor
     * @param TransformableInterface $object
     * @param TransformableInterface $target
     */
    public function __construct(
        TransformableInterface $actor,
        TransformableInterface $object,
        TransformableInterface $target
    ) {
        $this->id = (string)Str::orderedUuid();
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
     * @return TransformableInterface
     */
    public function getActor(): TransformableInterface
    {
        return $this->actor;
    }

    /**
     * @return TransformableInterface
     */
    public function getTarget(): TransformableInterface
    {
        return $this->target;
    }
    
    /**
     * @return TransformableInterface
     */
    public function getObject(): TransformableInterface
    {
        return $this->object;
    }
}
