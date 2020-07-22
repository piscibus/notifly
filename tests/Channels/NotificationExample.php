<?php


namespace Piscibus\Notifly\Tests\Channels;

use Illuminate\Notifications\Notification;
use Piscibus\Notifly\Channels\NotiflyChannel;
use Piscibus\Notifly\Contracts\ActorAble;
use Piscibus\Notifly\Contracts\NotiflyNotification as NotiflyNotificationContract;
use Piscibus\Notifly\Contracts\ObjectAble;
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
     * @var string
     */
    private $verb = 'my_verb';

    /**
     * @var string
     */
    private $targetType = TargetExample::class;

    /**
     * NotificationExample constructor.
     * @param ActorAble $actor
     * @param ObjectAble $object
     */
    public function __construct(ActorAble $actor, ObjectAble $object)
    {
        $this->actor = $actor;
        $this->object = $object;
    }

    /**
     * @return array
     */
    public function via()
    {
        return [NotiflyChannel::class];
    }
}
