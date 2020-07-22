<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Notifications\Notification;
use Piscibus\Notifly\Channels\NotiflyChannel;
use Piscibus\Notifly\Contracts\ActorAble;
use Piscibus\Notifly\Contracts\NotiflyNotification as NotiflyNotificationContract;
use Piscibus\Notifly\Contracts\ObjectAble;
use Piscibus\Notifly\Contracts\TargetAble;
use Piscibus\Notifly\Traits\NotiflyNotification;

class NotificationExample extends Notification implements NotiflyNotificationContract
{
    use NotiflyNotification;

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
     * @var string
     */
    private $verb = 'my_verb';

    /**
     * NotificationExample constructor.
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
