<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Notifications\Notification;
use Piscibus\Notifly\Channels\NotiflyChannel;
use Piscibus\Notifly\Contracts\ActorAble;
use Piscibus\Notifly\Contracts\NotiflyNotification;
use Piscibus\Notifly\Contracts\ObjectAble;
use Piscibus\Notifly\Contracts\TargetAble;

class CommentNotification extends Notification implements NotiflyNotification
{
    use \Piscibus\Notifly\Traits\NotiflyNotification;

    /**
     * @var string
     */
    private $verb = 'comment';

    /**
     * @var ActorAble
     */
    private $actor;

    /**
     * @var ObjectAble
     */
    private $object;

    /**
     * @var TargetAble
     */
    private $target;

    /**
     * LikeNotification constructor.
     * @param ActorAble $actor
     * @param ObjectAble $object
     * @param TargetAble $target
     */
    public function __construct(ActorAble $actor, ObjectAble $object, TargetAble $target)
    {
        $this->actor = $actor;
        $this->object = $object;
        $this->target = $target;
    }

    /**
     * @return array
     */
    public function via()
    {
        return [NotiflyChannel::class];
    }
}
