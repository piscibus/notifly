<?php


namespace Piscibus\Notifly\Tests\TestModels;

use Illuminate\Notifications\Notification;
use Piscibus\Notifly\Channels\NotiflyChannel;
use Piscibus\Notifly\Contracts\MorphAble;
use Piscibus\Notifly\Contracts\NotiflyNotification as NotiflyNotificationContract;
use Piscibus\Notifly\Traits\NotiflyNotification;

class NotificationExample extends Notification implements NotiflyNotificationContract
{
    use NotiflyNotification;

    /**
     * @var MorphAble
     */
    private $actor;

    /**
     * @var MorphAble
     */
    private $object;

    /**
     * @var MorphAble
     */
    private $target;

    /**
     * @var string
     */
    private $verb = 'my_verb';

    /**
     * NotificationExample constructor.
     * @param MorphAble $actor
     * @param MorphAble $object
     * @param MorphAble $target
     */
    public function __construct(MorphAble $actor, MorphAble $object, MorphAble $target)
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
